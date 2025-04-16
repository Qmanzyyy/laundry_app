function softDelete(id) {
    console.log("confirmDelete() dipanggil dengan userId:", id);
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Data Transaksi Akan Di Hapus!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        console.log("User mengonfirmasi hapus, mengirim request POST...");
        fetch("./components/function/softDeleteTransaksi.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "id=" + encodeURIComponent(id)
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