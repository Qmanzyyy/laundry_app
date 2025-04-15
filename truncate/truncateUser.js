const mysql = require('mysql2');

// Koneksi ke DB
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'laundry',
});

// Tabel yang mau dikosongkan
const tables = ['tb_user', 'tb_karyawan'];

// Fungsi utama
const truncateTables = () => {
  connection.query('SET FOREIGN_KEY_CHECKS = 0;', (err) => {
    if (err) return console.error('Gagal disable FK:', err);

    // Truncate semua tabel
    let done = 0;
    tables.forEach((table) => {
      connection.query(`TRUNCATE TABLE ${table}`, (err) => {
        if (err) return console.error(`Gagal truncate ${table}:`, err);
        console.log(`Berhasil truncate ${table}`);
        done++;
        if (done === tables.length) insertUser();
      });
    });
  });
};

// Insert ke tb_user
const insertUser = () => {
  connection.query(
    `INSERT INTO tb_user (nama, foto, username,password,id_outlet,role)
     VALUES ('Miftahur Rahman', '', 'miftahur', '$2a$10$SsfvYib4yKtcBtNBPpNucO77FRsxXpuibhHGTNXfBJ4xwnFAmqFcm',1,'owner')`,
    (err, result) => {
      if (err) return console.error('Gagal insert tb_user:', err);
      console.log('Berhasil insert tb_user');
      const idUser = result.insertId;
      insertKaryawan(idUser);
    }
  );
};

// Insert ke tb_karyawan
const insertKaryawan = (idUser) => {
  connection.query(
    `INSERT INTO tb_karyawan (nama, alamat, no_telp, posisi, id_user, gaji, shift_kerja)
     VALUES ('Miftahur Rahman', 'Dsn Pajaten Mas, Ds Bantarjati, Kec Kertajati', '081234567890', 'owner', ?, null, 'pagi')`,
    [idUser],
    (err) => {
      if (err) return console.error('Gagal insert tb_karyawan:', err);
      console.log('Berhasil insert tb_karyawan');
      enableFK();
    }
  );
};

// Aktifkan kembali foreign key
const enableFK = () => {
  connection.query('SET FOREIGN_KEY_CHECKS = 1;', (err) => {
    if (err) console.error('Gagal enable FK:', err);
    else console.log('Foreign key check diaktifkan kembali.');
    connection.end();
  });
};

truncateTables();
