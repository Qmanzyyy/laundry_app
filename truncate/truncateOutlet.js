const mysql = require('mysql2'); // Mengimpor library mysql2 untuk koneksi ke database

// Membuat koneksi ke database MySQL di XAMPP
const connection = mysql.createConnection({
  host: 'localhost',      // Host lokal, karena pakai XAMPP
  user: 'root',           // Username default MySQL di XAMPP
  password: '',           // Password default biasanya kosong
  database: 'laundry',    // Nama database yang akan digunakan
});

const truncateTables = () => {
  const tables = ['tb_outlet']; // Daftar tabel yang ingin dihapus datanya

  // Mematikan sementara pengecekan foreign key agar tidak error saat TRUNCATE
  connection.query('SET FOREIGN_KEY_CHECKS = 0;', (err) => {
    if (err) {
      console.error('Gagal mematikan foreign key check:', err);
      return;
    }

    // Menghapus semua isi dari tabel (TRUNCATE lebih cepat dari DELETE)
    connection.query(`TRUNCATE TABLE ${tables[0]}`, (err) => {
      if (err) {
        console.error(`Gagal mengosongkan tabel ${tables[0]}:`, err);
      } else {
        console.log(`Berhasil mengosongkan tabel ${tables[0]}`);

        // Setelah tabel dikosongkan, kita tambahkan data baru ke dalamnya
        connection.query(
          `INSERT INTO tb_outlet (nama, alamat, tlp)
           VALUES ('Cab Pajaten', 'DSN Pajaten Mas, DS Bantarjati, KEC Kertajati', '081234567890')`,
          (err) => {
            if (err) {
              console.error(`Gagal menambahkan data ke tb_outlet:`, err);
            } else {
              console.log(`Berhasil menambahkan data ke tb_outlet`);
            }

            // Mengaktifkan kembali pengecekan foreign key
            connection.query('SET FOREIGN_KEY_CHECKS = 1;', (err) => {
              if (err) {
                console.error('Gagal mengaktifkan foreign key check:', err);
              }

              // Terakhir, tutup koneksi ke database
              connection.end();
            });
          }
        );
      }
    });
  });
};

// Memanggil fungsi untuk menjalankan seluruh proses di atas
truncateTables();
