function confirmDelete(userId) {
    console.log("confirmDelete() dipanggil dengan userId:", userId);
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Data karyawan ini akan dihapus!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        console.log("User mengonfirmasi hapus, mengirim request POST...");
        fetch("./components/function/deleteUser.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "id=" + encodeURIComponent(userId)
        })
        .then(response => {
          console.log("Response dari server:", response);
          return response.text();
        })
        .then(text => {
          console.log("Response text:", text);
          if (text.indexOf("Success:") !== -1) {
            Swal.fire({ title: "Berhasil!", text: text, icon: "success" })
              .then(() => window.location.reload());
          } else {
            Swal.fire({ title: "Error!", text: text, icon: "error" });
          }
        })
        .catch(error => {
          console.error("Error dalam fetch:", error);
          Swal.fire({ title: "Error!", text: "Terjadi kesalahan saat menghapus data: " + error, icon: "error" });
        });
      }
    });
  }
  
  function openEditModal(button) {
    document.getElementById('edit_id').value = button.getAttribute('data-id');
    document.getElementById('edit_nama').value = button.getAttribute('data-nama');
    document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');
    document.getElementById('edit_telp').value = button.getAttribute('data-telp');
    document.getElementById('edit_shift').value = button.getAttribute('data-shift');
    document.getElementById('edit_role').value = button.getAttribute('data-role');
    document.getElementById('edit_username').value = button.getAttribute('data-username');
    document.getElementById('editModal').classList.remove('hidden');
  }
  
  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }