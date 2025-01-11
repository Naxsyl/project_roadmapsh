<?php

// Nama file JSON tempat data tugas disimpan
const TASKS_FILE = 'tasks.json';

// Fungsi untuk membaca data dari file JSON
function readTasks()
{
    if (!file_exists(TASKS_FILE)) {
        file_put_contents(TASKS_FILE, json_encode([]));
    }
    return json_decode(file_get_contents(TASKS_FILE), true);
}

// Fungsi untuk menulis data ke file JSON
function writeTasks($tasks)
{
    file_put_contents(TASKS_FILE, json_encode($tasks, JSON_PRETTY_PRINT));
}

// Fungsi untuk menampilkan pesan kesalahan
function error($message)
{
    echo "Error: $message\n";
    exit(1);
}

// Fungsi untuk menampilkan semua tugas
function listTasks($status = null)
{
    $tasks = readTasks();
    if ($status) {
        $tasks = array_filter($tasks, fn($task) => $task['status'] === $status);
    }
    if (empty($tasks)) {
        echo "No tasks found.\n";
        return;
    }
    foreach ($tasks as $task) {
        echo "ID: {$task['id']} | Description: {$task['description']} | Status: {$task['status']} | Created At: {$task['createdAt']} | Updated At: {$task['updatedAt']}\n";
    }
}

// Fungsi untuk menambah tugas baru
function addTask($description)
{
    $tasks = readTasks();
    $id = count($tasks) > 0 ? max(array_column($tasks, 'id')) + 1 : 1;
    $now = date('Y-m-d H:i:s');
    $tasks[] = [
        'id' => $id,
        'description' => $description,
        'status' => 'todo',
        'createdAt' => $now,
        'updatedAt' => $now
    ];
    writeTasks($tasks);
    echo "Task added successfully (ID: $id)\n";
}

// Fungsi untuk memperbarui tugas
function updateTask($id, $description)
{
    $tasks = readTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['description'] = $description;
            $task['updatedAt'] = date('Y-m-d H:i:s');
            writeTasks($tasks);
            echo "Task updated successfully.\n";
            return;
        }
    }
    error("Task with ID $id not found.");
}

// Fungsi untuk menghapus tugas
function deleteTask($id)
{
    $tasks = readTasks();
    $initialCount = count($tasks);
    $tasks = array_filter($tasks, fn($task) => $task['id'] != $id);

    // Jika tidak ada tugas yang dihapus, tampilkan pesan error
    if (count($tasks) === $initialCount) {
        echo "Tugas tidak ada maka tidak ada penghapusan file.\n";
        return;
    }

    writeTasks($tasks);
    echo "Task deleted successfully.\n";
}


// Fungsi untuk menandai tugas sebagai 'in-progress' atau 'done'
function markTask($id, $status)
{
    $tasks = readTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['status'] = $status;
            $task['updatedAt'] = date('Y-m-d H:i:s');
            writeTasks($tasks);
            echo "Task marked as $status successfully.\n";
            return;
        }
    }
    error("Task with ID $id not found.");
}

// Menjalankan program berdasarkan argumen dari CLI
$args = $argv;
array_shift($args); // Menghapus nama script

if (empty($args)) {
    error("No command provided.");
}

$command = array_shift($args);

switch ($command) {
    case 'add':
        if (empty($args)) {
            error("Task description is required.");
        }
        addTask(implode(" ", $args));
        break;
    case 'update':
        if (count($args) < 2) {
            error("Task ID and description are required.");
        }
        updateTask($args[0], implode(" ", array_slice($args, 1)));
        break;
    case 'delete':
        if (empty($args)) {
            error("Task ID is required.");
        }
        deleteTask($args[0]);
        break;
    case 'mark-in-progress':
        if (empty($args)) {
            error("Task ID is required.");
        }
        markTask($args[0], 'in-progress');
        break;
    case 'mark-done':
        if (empty($args)) {
            error("Task ID is required.");
        }
        markTask($args[0], 'done');
        break;
    case 'list':
        $status = $args[0] ?? null;
        if ($status && !in_array($status, ['todo', 'in-progress', 'done'])) {
            error("Invalid status. Valid statuses are: todo, in-progress, done.");
        }
        listTasks($status);
        break;
    default:
        error("Unknown command: $command");
}
