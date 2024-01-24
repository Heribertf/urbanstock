<?php
include("./includes/header.php");
include("./includes/sidebar.php");
?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <?php
        include("./includes/navbar.php");
        ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Registered Users</h1>
            <p class="mb-4">
                List of all Registered Users, both active and inactive.
            </p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Users DataTable
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Join Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Join Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include_once './includes/config.php';
                                include_once './includes/db_connection.php';
                                $i = 1;

                                $sql = "SELECT userId, CONCAT(firstName, ' ', lastName) AS fullName, phone, email, DATE_FORMAT(registerDate, '%d-%b-%Y') AS formattedDate, IF(verified = 1, 'Verified', 'Not-Verified') AS verificationStatus
                                                          FROM users
                                                          WHERE delete_flag = 0 AND type = 2";

                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_execute($stmt);

                                    // Bind the results to variables
                                    mysqli_stmt_bind_result($stmt, $userId, $fullName, $email, $phone, $formattedDate, $verificationStatus);

                                    while (mysqli_stmt_fetch($stmt)) {
                                        echo "<tr>";
                                        echo "<td>" . $i++ . "</td>";
                                        echo "<td>" . htmlspecialchars($fullName) . "</td>";
                                        echo "<td>" . htmlspecialchars($email) . "</td>";
                                        echo "<td>" . htmlspecialchars($phone) . "</td>";
                                        echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                                        if ($verificationStatus === 'Verified') {
                                            echo "<td><span class='badge border border-success text-success'>" . htmlspecialchars($verificationStatus) . "</span></td>";
                                        } else {
                                            echo "<td><span class='badge border border-secodary text-secondary'>" . htmlspecialchars($verificationStatus) . "</span></td>";
                                        }
                                        echo "<td>
                            <a href='#' class='btn btn-danger btn-icon-split'>
                              <span class='icon text-white-50'>
                                  <i class='fas fa-trash'></i>
                              </span>
                              <span class='text delete-user' dataUserId='" . htmlspecialchars($userId) . "'>Delete</span>
                            </a>
                            </td>";
                                        echo "</tr>";
                                    }

                                    mysqli_stmt_close($stmt);
                                } else {
                                    echo "Error in prepared statement: " . mysqli_error($conn);
                                }

                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <?php
    include("./includes/footer.php");
    ?>
    <script>
        $(document).ready(function () {
            $('.delete-user').on('click', function (e) {
                e.preventDefault();

                const userId = this.getAttribute('dataUserId');
                console.log(userId);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-2',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: 'Warning!',
                    text: "Are you sure you want to delete this user?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'me-2',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'POST',
                            url: './delete_user.php',
                            data: {
                                userId: userId
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'User Deleted',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(() => {
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
                                });
                            }
                        });
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Deletion aborted',
                            'error'
                        )
                    }
                });
            });
        })
    </script>
    <?php
    include("./includes/footer_end.php");
    ?>