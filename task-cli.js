const fs = require("fs");
const path = require("path");

// Nama file JSON tempat data tugas disimpan
const TASKS_FILE = path.join(__dirname, "tasks.json");

// Fungsi untuk membaca data dari file JSON
function readTasks() {
  if (!fs.existsSync(TASKS_FILE)) {
    fs.writeFileSync(TASKS_FILE, JSON.stringify([]));
  }
  return JSON.parse(fs.readFileSync(TASKS_FILE, "utf-8"));
}

// Fungsi untuk menulis data ke file JSON
function writeTasks(tasks) {
  fs.writeFileSync(TASKS_FILE, JSON.stringify(tasks, null, 2));
}

// Fungsi untuk menampilkan pesan kesalahan
function error(message) {
  console.error(`Error: ${message}`);
  process.exit(1);
}

// Fungsi untuk menampilkan semua tugas
function listTasks(status = null) {
  const tasks = readTasks();
  const filteredTasks = status
    ? tasks.filter((task) => task.status === status)
    : tasks;

  if (filteredTasks.length === 0) {
    console.log("No tasks found.");
    return;
  }

  filteredTasks.forEach((task) => {
    console.log(
      `ID: ${task.id} | Description: ${task.description} | Status: ${task.status} | Created At: ${task.createdAt} | Updated At: ${task.updatedAt}`
    );
  });
}

// Fungsi untuk menambah tugas baru
function addTask(description) {
  const tasks = readTasks();
  const id =
    tasks.length > 0 ? Math.max(...tasks.map((task) => task.id)) + 1 : 1;
  const now = new Date().toISOString();

  const newTask = {
    id,
    description,
    status: "todo",
    createdAt: now,
    updatedAt: now,
  };

  tasks.push(newTask);
  writeTasks(tasks);
  console.log(`Task added successfully (ID: ${id})`);
}

// Fungsi untuk memperbarui tugas
function updateTask(id, description) {
  const tasks = readTasks();
  const task = tasks.find((task) => task.id === id);

  if (!task) {
    console.log("Task not found. No updates made.");
    return;
  }

  task.description = description;
  task.updatedAt = new Date().toISOString();
  writeTasks(tasks);
  console.log("Task updated successfully.");
}

// Fungsi untuk menghapus tugas
function deleteTask(id) {
  const tasks = readTasks();
  const initialCount = tasks.length;

  const updatedTasks = tasks.filter((task) => task.id !== id);

  if (tasks.length === updatedTasks.length) {
    console.log("Tugas tidak ada maka tidak ada penghapusan file.");
    return;
  }

  writeTasks(updatedTasks);
  console.log("Task deleted successfully.");
}

// Fungsi untuk menandai tugas sebagai 'in-progress' atau 'done'
function markTask(id, status) {
  const tasks = readTasks();
  const task = tasks.find((task) => task.id === id);

  if (!task) {
    console.log("Task not found.");
    return;
  }

  task.status = status;
  task.updatedAt = new Date().toISOString();
  writeTasks(tasks);
  console.log(`Task marked as ${status} successfully.`);
}

// Menjalankan program berdasarkan argumen dari CLI
const [, , command, ...args] = process.argv;

switch (command) {
  case "add":
    if (args.length === 0) error("Task description is required.");
    addTask(args.join(" "));
    break;
  case "update":
    if (args.length < 2) error("Task ID and description are required.");
    updateTask(Number(args[0]), args.slice(1).join(" "));
    break;
  case "delete":
    if (args.length === 0) error("Task ID is required.");
    deleteTask(Number(args[0]));
    break;
  case "mark-in-progress":
    if (args.length === 0) error("Task ID is required.");
    markTask(Number(args[0]), "in-progress");
    break;
  case "mark-done":
    if (args.length === 0) error("Task ID is required.");
    markTask(Number(args[0]), "done");
    break;
  case "list":
    const status = args[0];
    if (status && !["todo", "in-progress", "done"].includes(status)) {
      error("Invalid status. Valid statuses are: todo, in-progress, done.");
    }
    listTasks(status);
    break;
  default:
    error(`Unknown command: ${command}`);
}
