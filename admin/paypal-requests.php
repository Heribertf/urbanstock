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
            <h1 class="h3 mb-2 text-gray-800">Payment requests</h1>
            <p class="mb-4">
                List of PayPal Payment Requests
            </p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Payments DataTable
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Requested Amt</th>
                                    <th>Receiving Amt</th>
                                    <th>PayPal Email</th>
                                    <th>Request Date</th>
                                    <th>Update Date</th>
                                    <th>TXN</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Requested Amt</th>
                                    <th>Receiving Amt</th>
                                    <th>PayPal Email</th>
                                    <th>Request Date</th>
                                    <th>Update Date</th>
                                    <th>TXN</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include_once './includes/config.php';
                                include_once './includes/db_connection.php';

                                $i = 1;

                                $query = "SELECT w.withdraw_id, w.user_id, w.withdraw_amount, w.recipient_email, DATE_FORMAT(w.withdraw_request_date, '%d-%b-%Y') AS formattedDate, DATE_FORMAT(w.updated, '%d-%b-%Y') AS updateDate, w.transaction_ref, w.comment,
                                        CASE
                                            WHEN w.status = 1 THEN 'Completed'
                                            WHEN w.status = 2 THEN 'Pending'
                                            WHEN w.status = 0 THEN 'Cancelled'
                                        END AS withdrawStatus, CONCAT(u.firstName, ' ' ,u.lastName) AS fullname
                                        FROM 
                                            withdrawals w
                                        JOIN 
                                            users u ON w.user_id = u.userId
                                        WHERE
                                            w.type = 2
                                        ORDER BY w.withdraw_request_date DESC";

                                if ($stmt = mysqli_prepare($conn, $query)) {
                                    //mysqli_stmt_bind_param($stmt, "ii", $image_id, $_SESSION["id"]);
                                    mysqli_stmt_execute($stmt);

                                    mysqli_stmt_bind_result($stmt, $withdrawId, $userId, $withdraw_amount, $recipient, $requested, $updated, $transaction_reference, $comment, $status, $fullname);

                                    if (mysqli_stmt_fetch($stmt)) {
                                        $transaction = 0.05;
                                        do {
                                            echo "<tr>";
                                            echo "<td>" . $i++ . "</td>";
                                            echo "<td>" . htmlspecialchars($fullname) . "</td>";
                                            echo "<td> Ksh " . number_format($withdraw_amount, 2) . "</td>";
                                            echo "<td>USD " . number_format(($withdraw_amount - ($withdraw_amount * $transaction)) / 150, 2) . "</td>";
                                            echo "<td>" . htmlspecialchars($recipient) . "</td>";
                                            echo "<td>" . htmlspecialchars($requested) . "</td>";
                                            echo "<td>" . htmlspecialchars($updated) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction_reference) . "</td>";
                                            echo "<td>" . htmlspecialchars($comment) . "</td>";
                                            if ($status === 'Completed') {
                                                echo "<td><span class='badge border border-success text-success'>" . htmlspecialchars($status) . "</span></td>";
                                            } else if ($status === 'Cancelled') {
                                                echo "<td><span class='badge border border-danger text-danger'>" . htmlspecialchars($status) . "</span></td>";
                                            } else if ($status === 'Pending') {
                                                echo "<td><span class='badge border border-warning text-warning'>" . htmlspecialchars($status) . "</span></td>";
                                            }
                                            echo "<td>
                                                <a href='#' class='btn btn-primary update-request' data-bs-toggle='modal' data-bs-target='#exampleModalCenter'
                                                    data-user-id='" . htmlspecialchars($userId) . "' data-withdraw-id='" . htmlspecialchars($withdrawId) . "'
                                                    data-amount='" . number_format(($withdraw_amount - ($withdraw_amount * $transaction)) / 150, 2) . "'
                                                    data-name='" . htmlspecialchars($fullname) . "' data-recipient='" . htmlspecialchars($recipient) . "'
                                                    data-status='" . htmlspecialchars($status) . "' data-withdraw-amount='" . htmlspecialchars($withdraw_amount) . "'>
                                                    <h5>Update</h5>
                                                </a>
                                            </td>";
                                            echo "</tr>";
                                        } while (mysqli_stmt_fetch($stmt));

                                        mysqli_stmt_close($stmt);
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

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Update Withdrawal Request</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="close"> <span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
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
        document.addEventListener('DOMContentLoaded', function () {
            const editLinks = document.querySelectorAll('.update-request');

            editLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    const updateModalReq = new bootstrap.Modal(document.getElementById('exampleModalCenter'));

                    const edit_user_id = this.getAttribute('data-user-id');
                    const edit_withdraw_id = this.getAttribute('data-withdraw-id');
                    const pay_amount = this.getAttribute('data-amount');
                    const user_name = this.getAttribute('data-name');
                    const recipient_email = this.getAttribute('data-recipient');
                    const request_status = this.getAttribute('data-status');
                    const withdraw_amount = this.getAttribute('data-withdraw-amount');

                    const selectOptions = `
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                        <option value="Pending">Pending</option>
                                    `;

                    const editModalTitle = document.getElementById('exampleModalCenterTitle');
                    const editModalBody = document.querySelector('.modal-body');

                    editModalTitle.textContent = "Update Request Status";
                    editModalBody.innerHTML = `
                    <div class="card">
                        <div class="alert alert-secondary" role="alert">
                            Once paid, update the status to <strong>Completed</strong>.
                            You can enter the transaction reference code in the transaction field for future references.<br>
                            Incase of cancelled request, provide a reason in the comment section.<br>
                            Remember you cannot revert a withdrawal request once marked completed.
                        </div>
                        <div class="card-body">
                            <h6 class="card-title">Updating Wthdrawal Request For: ${user_name}</h6>
                            <form class="forms-sample" enctype="multipart/form-data" method="post" id="request-update-form">
            
                                <div class="mb-3">
                                    <label for="user-name" class="form-label">User Name: ${user_name}</label>
                                </div>
                                <div class="mb-3">
                                    <label for="pay-amount" class="form-label">Amount Payable (After transaction cost): USD ${pay_amount}</label>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-number" class="form-label">Recipient Email: ${recipient_email}</label>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="edit_user_id" value="${edit_user_id}" required>
                                    <input type="hidden" name="edit_withdraw_id" value="${edit_withdraw_id}" required>
                                    <input type="hidden" name="withdraw_amount" value="${withdraw_amount}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editSubStatus" class="form-label">Transaction Ref (Optional):</label>
                                    <input class="form-control" type="text" name="transaction" >
                                </div>
                                <div class="mb-3">
                                    <label for="editSubStatus" class="form-label">Comment (Optional):</label>
                                    <textarea class="form-control" id="rejection_comment" name="rejection_comment" rows="5"
                                    maxlength="150" placeholder="Maximum characters accepted is 150 chars"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="editSubStatus" class="form-label">Update Withdraw Status:</label>
                                    <select class="form-control" name="editWthStatus" id="editWthStatus" required>
                                        ${selectOptions}
                                    </select>
                                </div>
                                <button type="submit" name="submit" value="upload" class="btn btn-primary me-2">Update
                                    Status
                                </button>
                            </form>
                        </div>
                    </div>`;

                    const selectElement = editModalBody.querySelector('#editWthStatus');
                    for (const option of selectElement.options) {
                        if (option.value === request_status) {
                            option.selected = true;
                            break;
                        }
                    }

                    // Show the modal
                    updateModalReq.show();

                    const editForm = document.getElementById('request-update-form');

                    editForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const formData = new FormData(editForm)

                        $.ajax({
                            type: 'POST',
                            url: './update_withdrawal_request.php',
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
                            error: function (xhr, status, error) {
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