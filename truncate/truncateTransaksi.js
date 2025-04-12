const mysql = require('mysql2');

// Membuat koneksi ke database MySQL di XAMPP
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root', // Biasanya 'root' di XAMPP
  password: '', // Password default kosong di XAMPP
  database: 'laundry', // Ganti dengan nama database kamu
});

// Menjalankan perintah TRUNCATE TABLE
const truncateTables = () => {
  const tables = ['tb_transaksi', 'tb_paket', 'tb_detail_transaksi', 'tb_member'];
  
  // Menonaktifkan pengecekan foreign key
  connection.query('SET FOREIGN_KEY_CHECKS = 0;', (err, results) => {
    if (err) {
      console.error('Error disabling foreign key checks:', err);
      return;
    }

    // Melakukan truncate pada tabel
    tables.forEach(table => {
      connection.query(`TRUNCATE TABLE ${table}`, (err, results) => {
        if (err) {
          console.error(`Error truncating ${table}:`, err);
        } else {
          console.log(`Successfully truncated ${table}`);
        }
      });
    });

    // Mengaktifkan kembali pengecekan foreign key
    connection.query('SET FOREIGN_KEY_CHECKS = 1;', (err, results) => {
      if (err) {
        console.error('Error enabling foreign key checks:', err);
      }
      // Menutup koneksi setelah selesai
      connection.end();
    });
  });
};

// Memanggil fungsi truncate
truncateTables();
