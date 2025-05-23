const mysql = require('mysql2');

// Ambil jumlah user dari argumen command-line
const jumlahUser = parseInt(process.argv[2]);

if (isNaN(jumlahUser) || jumlahUser <= 0) {
  console.error('Masukkan jumlah user yang valid. Contoh: npm run tambahdatauser 5');
  process.exit(1);
}

// Koneksi ke DB
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'laundry',
});

const roles = ['admin', 'kasir']; // role yang mungkin

// Fungsi utama
const tambahUser = (index = 1) => {
  if (index > jumlahUser) {
    console.log(`✅ Selesai menambahkan ${jumlahUser} user.`);
    connection.end();
    return;
  }

  const nama = `User ${index}`;
  const username = `user${index}`;
  const passwordHash = '$2a$10$SsfvYib4yKtcBtNBPpNucO77FRsxXpuibhHGTNXfBJ4xwnFAmqFcm'; // hash statis
  const role = roles[Math.floor(Math.random() * roles.length)]; // pilih random

  const queryUser = `
    INSERT INTO tb_user (nama, foto, username, password, id_outlet, role)
    VALUES (?, '', ?, ?, 1, ?)
  `;

  connection.query(queryUser, [nama, username, passwordHash, role], (err, result) => {
    if (err) {
      console.error(`❌ Gagal insert user ke-${index}:`, err);
      tambahUser(index + 1);
      return;
    }

    const idUser = result.insertId;
    const queryKaryawan = `
      INSERT INTO tb_karyawan (nama, alamat, no_telp, posisi, id_user, gaji, shift_kerja)
      VALUES (?, 'Alamat default', '08123456789', 'owner', ?, NULL, 'pagi')
    `;

    connection.query(queryKaryawan, [nama, idUser], (err) => {
      if (err) {
        console.error(`❌ Gagal insert karyawan untuk user ke-${index}:`, err);
      } else {
        console.log(`✅ Berhasil insert user & karyawan ke-${index} dengan role ${role}`);
      }
      tambahUser(index + 1);
    });
  });
};

// Mulai
tambahUser();
