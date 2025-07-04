<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="./assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./assets/css/auth.css" rel="stylesheet">
</head>

<body>
    <section>
        <div class="container">
            <div class="user signinBx">
                <div class="imgBx"><img src="./assets/img/bg-auth.jpg" alt="" /></div>
                <div class="formBx">
                    <form id="register-form" method="POST">
                        <h2>Create an account</h2>
                        <input type="text" name="first_name" id="first_name" placeholder="First Name" required />
                        <input type="text" name="last_name" id="last_name" placeholder="Last Name" required />
                        <input type="email" name="email" id="email" placeholder="Email Address" required />
                        <input type="password" name="password" id="password" placeholder="Create Password" required />
                        <input type="password" name="conf_password" id="conf_password" placeholder="Confirm Password"
                            required />
                        <input type="submit" name="" value="Register" />
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="./assets/js/auth.js"></script>
</body>

</html>