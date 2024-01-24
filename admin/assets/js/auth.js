$(document).ready(function () {
  $("#login-form").submit(function (e) {
    e.preventDefault();

    var formData = new FormData($(this)[0]);
    $.ajax({
      type: "POST",
      url: "./login_check",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          window.location.href = "./index";
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: response.message,
          });
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr);
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An unexpected error occurred.",
        });
      },
    });
  });

  $("#register-form").submit(function (e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
      type: "POST",
      url: "./register_check",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        // $('#my-loader').hide();
        if (response.success) {
          Swal.fire({
            title: "Account Created",
            text: response.message,
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
            },
          }).then((result) => {
            window.location.href = "./login";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: response.message,
          });
        }
      },
      error: function (xhr, status, error) {
        // $('#my-loader').hide();
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An unexpected error occurred.",
        });
      },
    });
  });

  function isPasswordStrong(password) {
    // Password should be at least 8 characters long and contain a combination of uppercase, lowercase, and numbers.
    var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");
    return strongRegex.test(password);
  }
});
