const mysql = require('mysql2');

// Koneksi ke DB
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'laundry',
});

const tables = ['tb_user', 'tb_karyawan'];

const truncateTables = () => {
  connection.query('SET FOREIGN_KEY_CHECKS = 0;', (err) => {
    if (err) {
      console.error('Gagal disable FK:', err);
      return connection.end();
    }

    let done = 0;
    tables.forEach((table) => {
      connection.query(`TRUNCATE TABLE ${table}`, (err) => {
        if (err) {
          console.error(`Gagal truncate ${table}:`, err);
          return connection.end();
        }
        console.log(`Berhasil truncate ${table}`);
        done++;
        if (done === tables.length) insertUser();
      });
    });
  });
};

const insertUser = () => {
  const sql = `
    INSERT INTO tb_user (nama, foto, username, password, id_outlet, role) VALUES ?
  `;

  const values = [
    ['Miftahur Rahman', '', 'miftahur', '$2a$10$SsfvYib4yKtcBtNBPpNucO77FRsxXpuibhHGTNXfBJ4xwnFAmqFcm', 1, 'admin'],
    ['Riezky Chahya Saputra', '', 'riezky', '$2a$10$QjhCVpmYHzU0eQWqoBq6Ju14uk04ggD6lf37CWWhfxgf/Uiw/J.qW', 1, 'owner']
  ];

  connection.query(sql, [values], (err, result) => {
    if (err) {
      console.error('Gagal insert tb_user:', err);
      return connection.end();
    }
    console.log('Berhasil insert tb_user:', result.affectedRows, 'baris');

    const idUserPertama = result.insertId;
    insertKaryawan(idUserPertama);
  });
};

const insertKaryawan = (firstUserId) => {
  const karyawanValues = [
    ['Miftahur Rahman', 'Dsn Pajaten Mas, Ds Bantarjati, Kec Kertajati', '081234567890', 'admin', firstUserId, null, 'pagi'],
    ['Riezky Chahya Saputra', 'Jl. Mawar No. 5', '081234567891', 'kasir', firstUserId + 1, null, 'malam']
  ];

  const sql = `
    INSERT INTO tb_karyawan (nama, alamat, no_telp, posisi, id_user, gaji, shift_kerja) VALUES ?
  `;

  connection.query(sql, [karyawanValues], (err) => {
    if (err) {
      console.error('Gagal insert tb_karyawan:', err);
      return connection.end();
    }
    console.log('Berhasil insert tb_karyawan');
    enableFK();
  });
};

const enableFK = () => {
  connection.query('SET FOREIGN_KEY_CHECKS = 1;', (err) => {
    if (err) console.error('Gagal enable FK:', err);
    else console.log('Foreign key check diaktifkan kembali.');
    connection.end();
  });
};

truncateTables();
