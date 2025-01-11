# **Project Task Tracker CLI**

Task Tracker CLI adalah aplikasi Command Line Interface (CLI) sederhana untuk mengelola daftar tugas. Saya Membuat 2 file Task Tracker CLI yang satu menggunakan PHP dan satunya lagi menggunakan Javascript. Task Tracker CLI Memiliki fitur untuk menambah, memperbarui, menghapus, menandai status tugas, dan menampilkan daftar tugas berdasarkan status tertentu.

https://roadmap.sh/projects/task-tracker

## **Fitur**

- **Tambah Tugas:** Menambahkan tugas baru ke daftar.
- **Perbarui Tugas**: Memperbarui deskripsi tugas berdasarkan ID.
- **Hapus Tugas**: Menghapus tugas berdasarkan ID.
- **Tandai Tugas**:
  - **In Progress**: Menandai tugas sedang dalam proses.
  - **Done**: Menandai tugas selesai.

##

## **Usage/Examples**

**Menambahkan Tugas**

```bash
<php/node> task-cli.php add "<deskripsi tugas>"
```

**Contoh**:

```bash
php task-cli.php add "Belajar PHP"
node task-cli.js add "Belajar Node.js"
```

---

**Memperbarui Tugas**

```bash
<php/node> task-cli.php update <id> "<deskripsi baru>"
```

**Contoh**:

```bash
php task-cli.php update 1 "Belajar PHP dan MySQL"
node task-cli.js update 1 "Belajar Node.js dan Express.js"
```

---

**Menghapus Tugas**

```bash
<php/node> task-cli.php delete <id>
```

**Contoh**:

```bash
php task-cli.php delete 1
node task-cli.js delete 1
```

---

**Menandai Tugas**

- **Sebagai 'in-progress'**

```bash
<php/node> task-cli.php mark-in-progress <id>
```

**Contoh**:

```bash
php task-cli.php mark-in-progress 1
node task-cli.js mark-in-progress 1
```

- **Sebagai 'done'**

```bash
<php/node> task-cli.php mark-done <id>
```

**Contoh**:

```bash
php task-cli.php mark-done 1
node task-cli.js mark-done 1
```

---

**Menampilkan Tugas**

- **Semua Tugas**

```bash
<php/node> task-cli.php list
```

**Contoh**:

```bash
php task-cli.php list
node task-cli.js list
```

- **Tugas Berdasarkan Status**

```bash
<php/node> task-cli.php list <status>
```

**Status yang valid**: `todo`, `in-progress`, `done`  
**Contoh**:

```bash
php task-cli.php list done
node task-cli.js list done
```

---

### **Catatan**

- File `tasks.json` digunakan untuk menyimpan data tugas secara otomatis. Jangan ubah file ini secara manual.

---

README ini sudah mencakup semua perintah yang bisa digunakan. Kalau ada hal lain yang ingin ditambahkan, beri tahu ya! 😊
