$(document).ready(function () {
    $('#log-form').submit(function (e) {
        e.preventDefault();

        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: './login-check',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.location.href = "./investment";
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.'
                })
            }
        });
    });

    $('#reg-form').submit(function (e) {
        e.preventDefault();

        // Perform password strength check
        // var password = $('#password').val();
        // if (!isPasswordStrong(password)) {
        //   Swal.fire({
        //     icon: 'error',
        //     title: 'Weak Password',
        //     text: 'Password should be at least 8 characters long and contain a combination of uppercase, lowercase, and numbers.'
        //   });
        //   return;
        // }

        // Continue with form submission if password is strong
        // $('#my-loader').show();

        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: './register-check',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                // $('#my-loader').hide();
                if (response.success) {
                    Swal.fire({
                        title: "Account Created",
                        text: response.message,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    }).then((result) => {
                        window.location.href = "./login";
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
                // $('#my-loader').hide();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.'
                });
            }
        });
    });

    function isPasswordStrong(password) {
        // Password should be at least 8 characters long and contain a combination of uppercase, lowercase, and numbers.
        var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");
        return strongRegex.test(password);
    }
});