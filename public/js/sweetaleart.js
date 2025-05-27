document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(function (form) {
        const deleteButton = form.querySelector('.btn-delete');

        if (deleteButton) {
            deleteButton.addEventListener('click', function (event) {
                event.preventDefault(); // Mencegah form dikirim langsung
                
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Jika dikonfirmasi, submit form
                    }
                });
            });
        }
    });
});