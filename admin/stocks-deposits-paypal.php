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
            <h1 class="h3 mb-2 text-gray-800">Stock Deposits via PayPal</h1>
            <p class="mb-4">List of all stock deposits via paypal</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Deposits DataTable
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>TXN</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>TXN</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include_once './includes/config.php';
                                include_once './includes/db_connection.php';
                                $i = 1;

                                $query = "SELECT i.investment_id, i.user_id, i.capital, DATE_FORMAT(i.investment_date, '%d-%b-%Y') AS Date, i.txn, i.payment_status AS status,
                                            CONCAT(u.firstName, ' ', u.lastName) AS fullname, u.phone, s.stock_id, s.stock_name
                                            FROM 
                                                investments i
                                            JOIN
                                                users u ON i.user_id = u.userId
                                            JOIN
                                                stocks s ON i.stock_id = s.stock_id
                                            WHERE 
                                                i.payment_mode = 'paypal'
                                            ORDER BY i.investment_date DESC";

                                if ($result = mysqli_prepare($conn, $query)) {
                                    mysqli_stmt_execute($result);

                                    mysqli_stmt_bind_result($result, $investment_id, $user_id, $capital, $Date, $txn, $status, $fullName, $phone, $stock_id, $stock_name);

                                    if (mysqli_stmt_fetch($result)) {
                                        do {
                                            echo "<tr>";
                                            echo "<td>" . $i++ . "</td>";
                                            echo "<td>" . htmlspecialchars($fullName) . "</td>";
                                            echo "<td>" . htmlspecialchars($stock_name) . "</td>";
                                            echo "<td>Ksh " . htmlspecialchars($capital) . "</td>";
                                            echo "<td>" . htmlspecialchars($Date) . "</td>";
                                            echo "<td>" . htmlspecialchars($phone) . "</td>";
                                            echo "<td>" . htmlspecialchars($txn) . "</td>";
                                            echo "<td>";
                                            switch ($status) {
                                                case 'Completed':
                                                    echo "<span class='badge border border-success text-success'>" . htmlspecialchars($status) . "</span>";
                                                    break;
                                                case 'unconfirmed':
                                                    echo "<span class='badge border border-secondary text-secondary'>" . htmlspecialchars($status) . "</span>";
                                                    break;
                                                case 'rejected':
                                                    echo "<span class='badge border border-danger text-danger'>" . htmlspecialchars($status) . "</span>";
                                                    break;
                                                default:
                                                    echo htmlspecialchars($status);
                                            }
                                            echo "</td>";
                                            echo '<td style="
                                                    display: flex;
                                                    gap: 10px;
                                                    justify-content: flex-end;
                                                ">
                                                <a href="#" class="btn btn-primary btn-icon-split update-request" data-toggle="modal" data-target="#exampleModalCenter"
                                                data-user-id="' . htmlspecialchars($user_id) . '" data-investment-id="' . htmlspecialchars($investment_id) . '"
                                                data-stock-id="' . htmlspecialchars($stock_id) . '" data-transaction-code="' . htmlspecialchars($txn) . '" data-stock-name="' . htmlspecialchars($stock_name) . '"
                                                data-name="' . htmlspecialchars($fullName) . '" data-recipient="' . htmlspecialchars($phone) . '"
                                                data-status="' . htmlspecialchars($status) . '" data-paid-amount="' . htmlspecialchars($capital) . '">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    <span class="text">Edit</span>
                                                </a>
                                            </td>';
                                            echo "</tr>";
                                        } while (mysqli_stmt_fetch($result));

                                        mysqli_stmt_close($result);
                                    } else {
                                        echo '<tr><td colspan="5" class="text-center">No records found.</td></tr>';
                                    }
                                } else {
                                    error_log("Error in prepared statement: " . mysqli_error($conn));
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Update Withdrawal Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->
    <?php
    include("./includes/footer.php");
    ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wUo7ZnH8e7XpHA5P0Nl+UvE3v5PiixN6OpCv1d+3FLb6EGGo1R8aEsA/D3ebf6U" crossorigin="anonymous">

    <!-- Bootstrap JS (popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-bT5BRx+pO8+IIxk8jrv6IQFDuJ/8MyGtFJ8jA4mn1CeWZL62R4XN54l3zuZBhJZv" crossorigin="anonymous">
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editLinks = document.querySelectorAll('.update-request');

        editLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();

                const edit_user_id = this.getAttribute('data-user-id');
                const edit_investment_id = this.getAttribute('data-investment-id');
                const user_name = this.getAttribute('data-name');
                const recipient_number = this.getAttribute('data-recipient');
                const request_status = this.getAttribute('data-status');
                const paid_amount = this.getAttribute('data-paid-amount');
                const transaction_code = this.getAttribute('data-transaction-code');
                const stock_name = this.getAttribute('data-stock-name');
                const stock_id = this.getAttribute('data-stock-id');

                const selectOptions = `
                                        <option value="Completed">Completed</option>
                                        <option value="unconfirmed">Unconfirmed</option>
                                        <option value="rejected">Rejected</option>
                                    `;

                const editModalTitle = document.getElementById('exampleModalCenterTitle');
                const editModalBody = document.querySelector('.modal-body');

                editModalTitle.textContent = "Update Request Status";
                editModalBody.innerHTML = `
                    <div class="card">
                        <div class="alert alert-secondary" role="alert">
                            PayPal Payment Status Update
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Updating Payment Request For: ${user_name}</h6>
                            <form class="forms-sample" enctype="multipart/form-data" method="post" id="request-update-form">
            
                                <div class="mb-3">
                                    <label for="user-name" class="form-label">Full Names: ${user_name}</label>
                                </div>
                                <div class="mb-3">
                                    <label for="transaction-code" class="form-label">Transaction Code: ${transaction_code}</label>
                                </div>
                                <div class="mb-3">
                                    <label for="paid-amount" class="form-label">Paid Amount: ${paid_amount}</label>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-number" class="form-label">Recipient Number: ${recipient_number}</label>
                                </div>
                                <div class="mb-3">
                                    <label for="stock-name" class="form-label">Stock Name: ${stock_name}</label>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="edit_user_id" value="${edit_user_id}" required>
                                    <input type="hidden" name="edit_investment_id" value="${edit_investment_id}" required>
                                    <input type="hidden" name="stock_id" value="${stock_id}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editSubStatus" class="form-label">Update Submission Status:</label>
                                    <select class="form-control" name="editSubStatus" id="editSubStatus" required>
                                        ${selectOptions}
                                    </select>
                                </div>
                                <button type="submit" name="submit" value="upload" class="btn btn-primary me-2">Update
                                    Status
                                </button>
                            </form>
                        </div>
                    </div>`;

                const selectElement = editModalBody.querySelector('#editSubStatus');
                for (const option of selectElement.options) {
                    if (option.value === request_status) {
                        option.selected = true;
                        break;
                    }
                }

                const editForm = document.getElementById('request-update-form');

                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(editForm)

                    $.ajax({
                        type: 'POST',
                        url: './update_stocks_mpesa.php',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
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
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An unexpected error occurred.'
                            });
                        }
                    });
                });
            });
        });
    });
    </script>
    <?php
    include("./includes/footer_end.php");
    ?>