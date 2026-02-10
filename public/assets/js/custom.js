$(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();

    let url = $(this).data("url");
    let name = $(this).data("name") ?? "data ini";

    Swal.fire({
        title: "Yakin hapus?",
        text: `Data ${name}`,
        icon: "warning",
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (res) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    let message = "Terjadi kesalahan saat menghapus data.";

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        message = Object.values(errors)[0][0];
                    }
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: message,
                    });
                },
            });
        }
    });
});
