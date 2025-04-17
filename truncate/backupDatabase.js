const mysqldump = require('mysqldump');
const fs = require('fs');
const path = require('path');

// Buat folder backup jika belum ada
const backupDir = path.join(__dirname, 'backup');
if (!fs.existsSync(backupDir)) {
  fs.mkdirSync(backupDir);
}

// Buat nama file backup berdasarkan tanggal
const tanggal = new Date().toISOString().split('T')[0]; // YYYY-MM-DD
const outputFile = path.join(backupDir, `db_${tanggal}.sql`);

// Jalankan backup
mysqldump({
  connection: {
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'laundry',
  },
  dumpToFile: outputFile,
}).then(() => {
  console.log(`✅ Backup berhasil disimpan di: ${outputFile}`);
}).catch((err) => {
  console.error('❌ Gagal backup:', err);
});
