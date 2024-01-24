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
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Stocks Management</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="createStocksLink"><i
                        class="fas fa-download fa-sm text-white-50"></i>Create
                    Stocks</a>
            </div>

            <!-- Page Heading -->
            <!-- <h1 class="h3 mb-2 text-gray-800">Stocks Management</h1> -->
            <p class="mb-4">List of all Stocks</p>

            <!-- DataTales Example -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Stocks DataTable</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Stock Name</th>
                                    <th>Interest Rate</th>
                                    <th>Min Stock Amount</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Stock Name</th>
                                    <th>Interest Rate</th>
                                    <th>Min Stock Amount</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include_once './includes/config.php';
                                include_once './includes/db_connection.php';
                                $i = 1;

                                $sql = "SELECT stock_id, stock_name, percentage_interest, IF(stock_status = 1, 'Active', 'Not-Active') AS stock_status
                            FROM stocks
                            WHERE delete_flag = 0";

                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_execute($stmt);
                                    // Bind the results to variables
                                    mysqli_stmt_bind_result($stmt, $stock_id, $stock_name, $percentage_interest, $stock_status);

                                    while (mysqli_stmt_fetch($stmt)) {
                                        echo "<tr>";
                                        echo "<td>" . $i++ . "</td>";
                                        echo "<td>" . htmlspecialchars($stock_name) . "</td>";
                                        echo "<td>" . htmlspecialchars($percentage_interest) . "%</td>";
                                        echo "<td> Ksh 2,500</td>";
                                        if ($stock_status === 'Active') {
                                            echo "<td><span class='badge border border-success text-success'>" . htmlspecialchars($stock_status) . "</span></td>";
                                        } else {
                                            echo "<td><span class='badge border border-secondary text-secondary'>" . htmlspecialchars($stock_status) . "</span></td>";
                                        }
                                        echo '<td style="
                                                display: flex;
                                                gap: 10px;
                                                justify-content: flex-end;
                                            ">
                                            <a href="#" class="btn btn-primary btn-icon-split edit-stock"
                                            >
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Edit</span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon-split delete-stock" dataStockId="' . htmlspecialchars($stock_id) . '">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Delete</span>
                                            </a>
                                        </td>';
                                        echo "<tr>";
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
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Add your modal content here -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form or other content here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Stock Modal -->
    <div class="modal fade" id="editStockModal" tabindex="-1" role="dialog" aria-labelledby="editStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStockModalLabel">Edit Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Edit Stock Form -->
                    <form id="editStockForm">
                        <input type="hidden" name="stockId">
                        <div class="form-group">
                            <label for="stockName">Stock Name</label>
                            <input type="text" class="form-control" id="stockName" name="stockName"
                                placeholder="Enter stock name">
                        </div>
                        <div class="form-group">
                            <label for="stockPercentage">Stock Percentage Growth</label>
                            <input type="number" class="form-control" id="stockPercentage" name="stockPercentage"
                                placeholder="Enter stock percentage">
                        </div>
                        <!-- Add more form fields if needed -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editStockBtn">Update</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Create Stocks Modal -->
    <div class="modal fade" id="createStocksModal" tabindex="-1" role="dialog" aria-labelledby="createStocksModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStocksModalLabel">Create New Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="createStocks">
                        <div class="form-group">
                            <label for="stockName">Stock Name</label>
                            <input type="text" class="form-control" name="stock_name" id="stock_name"
                                placeholder="Enter stock name" required>
                        </div>
                        <div class="form-group">
                            <label for="stockQuantity">Stock Percentage Interest</label>
                            <input type="number" class="form-control" name="stock_interest" id="stock_interest"
                                placeholder="Enter one time percentage interest" required>
                        </div>
                        <div class="form-group">
                            <label for="stockQuantity">Set Status</label>
                            <select class="form-control" name="stock_status" id="stock_status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
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
    <!-- Add this script at the end of your HTML body -->
    <script>
        $(document).ready(function () {

            const create_stock = new bootstrap.Modal(document.getElementById('createStocksModal'));

            $('#createStocksLink').on('click', function () {

                // Show the modal
                create_stock.show();
            });

            // Edit stock modal setup
            const editStockModal = new bootstrap.Modal(document.getElementById('editStockModal'));

            // Open the modal when edit button is clicked
            $('.edit-stock').on('click', function () {
                const stockId = $(this).closest('tr').find('.delete-stock').attr('dataStockId');
                const stockName = $(this).closest('tr').find('td:eq(1)').text();
                const stockPercentage = $(this).closest('tr').find('td:eq(2)').text().replace('%',
                    ''); // Remove '%' from the percentage

                // Set values in the modal form
                $('#editStockForm input[name="stockId"]').val(stockId);
                $('#editStockForm input[name="stockName"]').val(stockName);
                $('#editStockForm input[name="stockPercentage"]').val(stockPercentage);

                // Show the modal
                editStockModal.show();
            });

            // AJAX form submission for updating stock
            $('#editStockBtn').on('click', function () {
                const formData = $('#editStockForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: './update_stock.php',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Stock Updated',
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

                // Close the modal after submission
                editStockModal.hide();
            });


            $('.delete-stock').on('click', function (e) {
                e.preventDefault();

                const stockId = this.getAttribute('dataStockId');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-2',
                        cancelButton: 'btn btn-danger me-2'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: 'Warning!',
                    text: "Are you sure you want to delete this stock?",
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
                            url: './delete_stock.php',
                            data: {
                                stockId: stockId
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Stock Deleted',
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
        });

        document.addEventListener("DOMContentLoaded", function () {
            const create_stock_form = document.getElementById("createStocks");

            create_stock_form.addEventListener("submit", function (e) {
                e.preventDefault();

                // Ensure the FormData constructor receives the form element
                const formData = new FormData(create_stock_form);

                $.ajax({
                    type: "POST",
                    url: "./create-stock.php",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Stock Created',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                location.reload();
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
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An unexpected error occurred.",
                        });
                    },
                });
            });
        });
    </script>

    <?php
    include("./includes/footer_end.php");
    ?>