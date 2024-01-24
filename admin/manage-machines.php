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
                <h1 class="h3 mb-0 text-gray-800">Machines Management</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="createMachines"><i
                        class="fas fa-download fa-sm text-white-50"></i>Create
                    Machine</a>
            </div>

            <!-- Page Heading -->
            <!-- <h1 class="h3 mb-2 text-gray-800">Stocks Management</h1> -->
            <p class="mb-4">List of all Machines</p>

            <!-- DataTales Example -->
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">
                        Machines DataTable
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Machine Name</th>
                                    <th>Series</th>
                                    <th>% Growth</th>
                                    <th>Amount</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Machine Name</th>
                                    <th>Series</th>
                                    <th>% Growth</th>
                                    <th>Amount</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include_once './includes/config.php';
                                include_once './includes/db_connection.php';
                                $i = 1;

                                $sql = "SELECT machine_id, machine_name, percentage_interest, machine_price, IF(machine_status = 1, 'Active', 'Not-Active') AS machine_status
                            FROM machines
                            WHERE delete_flag = 0";

                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_execute($stmt);
                                    // Bind the results to variables
                                    mysqli_stmt_bind_result($stmt, $machine_id, $machine_name, $percentage_interest, $machine_price, $machine_status);

                                    while (mysqli_stmt_fetch($stmt)) {
                                        echo "<tr>";
                                        echo "<td>" . $i++ . "</td>";
                                        echo "<td>" . htmlspecialchars($machine_name) . "</td>";
                                        echo "<td> V-Series </td>";
                                        echo "<td>" . htmlspecialchars($percentage_interest) . "%</td>";
                                        echo "<td>" . htmlspecialchars($machine_price) . "</td>";

                                        if ($machine_status === 'Active') {
                                            echo "<td><span class='badge border border-success text-success'>" . htmlspecialchars($machine_status) . "</span></td>";
                                        } else {
                                            echo "<td><span class='badge border border-secondary text-secondary'>" . htmlspecialchars($machine_status) . "</span></td>";
                                        }
                                        echo '<td style="
                                                display: flex;
                                                gap: 10px;
                                                justify-content: flex-end;
                                            ">
                                            <a href="#" class="btn btn-primary btn-icon-split edit-machine">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Edit</span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon-split delete-machine" dataMachineId="' . htmlspecialchars($machine_id) . '">
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

            <!-- Create Machines Modal -->
            <div class="modal fade" id="createMachinesModal" tabindex="-1" role="dialog"
                aria-labelledby="createMachinesModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createMachinesModalLabel">Create New Machine</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" id="createNewMachine">
                                <div class="form-group">
                                    <label for="stockName">Machine Name:</label>
                                    <input type="text" class="form-control" name="machine_name" id="machine_name"
                                        placeholder="Enter machine name" required>
                                </div>
                                <div class="form-group">
                                    <label for="stockQuantity">Subscription Price:</label>
                                    <input type="number" class="form-control" name="machine_price" id="machine_price"
                                        placeholder="Enter machine subscription amount" required>
                                </div>
                                <div class="form-group">
                                    <label for="stockQuantity">Percentage Interest per Hour:</label>
                                    <input type="number" class="form-control" name="machine_interest"
                                        id="machine_interest" placeholder="Enter percentage interest per hour" required>
                                </div>
                                <div class="form-group">
                                    <label for="stockQuantity">Set Status</label>
                                    <select class="form-control" name="machine_status" id="machine_status" required>
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

            <!-- Edit Stock Modal -->
            <div class="modal fade" id="editMachineModal" tabindex="-1" role="dialog"
                aria-labelledby="editMachineModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMachineModalLabel">Edit Machine...</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Edit Stock Form -->
                            <form id="editMachineForm">
                                <input type="hidden" name="machineId">
                                <div class="form-group">
                                    <label for="machineName">Machine Name</label>
                                    <input type="text" class="form-control" id="machineName" name="machineName"
                                        placeholder="Enter machine name">
                                </div>
                                <div class="form-group">
                                    <label for="machinePercentage">Machine Percentage Growth</label>
                                    <input type="number" class="form-control" id="machinePercentage"
                                        name="machinePercentage" placeholder="Enter Machine percentage">
                                </div>
                                <div class="form-group">
                                    <label for="machineAmount">Machine Amount</label>
                                    <input type="number" class="form-control" id="machineAmount" name="machineAmount"
                                        placeholder="Enter machine Amount">
                                </div>
                                <div class="form-group">
                                    <label for="machineStatus">machine Status</label>
                                    <select class="form-control" id="machineStatus" name="machineStatus">
                                        <option value="Active">Active</option>
                                        <option value="Not-Active">Not-Active</option>
                                    </select>
                                </div>
                                <!-- Add more form fields if needed -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="editMachineBtn">Update</button>
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
    document.addEventListener("DOMContentLoaded", function() {
        const create_machine = new bootstrap.Modal(document.getElementById('createMachinesModal'));

        $('#createMachines').on('click', function() {

            // Show the modal
            create_machine.show();
        });
        const create_machine_form = document.getElementById("createNewMachine");

        create_machine_form.addEventListener("submit", function(e) {
            e.preventDefault();

            // Ensure the FormData constructor receives the form element
            const formData = new FormData(create_machine_form);

            $.ajax({
                type: "POST",
                url: "./create-machine.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Machine Created',
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
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "An unexpected error occurred.",
                    });
                },
            });
        });

        // Edit stock modal setup
        const editMachineModal = new bootstrap.Modal(document.getElementById('editMachineModal'));

        // Open the modal when edit button is clicked
        $('.edit-machine').on('click', function() {
            const machineId = $(this).closest('tr').find('.delete-machine').attr('dataMachineId');
            const machineName = $(this).closest('tr').find('td:eq(1)').text();
            const machinePercentage = $(this).closest('tr').find('td:eq(3)').text().replace('%', '');
            const machineAmount = $(this).closest('tr').find('td:eq(4)').text(); // Corrected index
            const machineStatus = $(this).closest('tr').find('td:eq(5)').text().trim();


            // Set values in the modal form
            $('#editMachineForm input[name="machineId"]').val(machineId);
            $('#editMachineForm input[name="machineName"]').val(machineName);
            $('#editMachineForm input[name="machinePercentage"]').val(machinePercentage);
            $('#editMachineForm input[name="machineAmount"]').val(machineAmount);
            $('#editMachineForm input[name="machineStatus"]').val(machineStatus);

            // Show the modal
            editMachineModal.show();
        });

        // AJAX form submission for updating stock
        $('#editMachineBtn').on('click', function() {
            const formData = $('#editMachineForm').serialize();

            $.ajax({
                type: 'POST',
                url: './update_machine.php',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Machines Updated',
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
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred.'
                    });
                }
            });

            // Close the modal after submission
            editMachineModal.hide();
        });


        $('.delete-machine').on('click', function(e) {
            e.preventDefault();

            const machineId = this.getAttribute('dataMachineId');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success m-2',
                    cancelButton: 'btn btn-danger me-2'
                },
                buttonsStyling: false,
            })

            swalWithBootstrapButtons.fire({
                title: 'Warning!',
                text: "Are you sure you want to delete this Machine?",
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
                        url: './delete_machine.php',
                        data: {
                            machineId: machineId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Machine Deleted',
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
                        error: function(xhr, status, error) {
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
    </script>
    <?php
    include("./includes/footer_end.php");
    ?>