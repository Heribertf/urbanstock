
document.addEventListener('DOMContentLoaded', function () {
    const withdraw = document.getElementById('withdraw-form');

    withdraw.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(withdraw);
        $.ajax({
            type: 'POST',
            url: './withdrawal.php',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.'
                })
            }
        });
    });
});