<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Linking Huts</title> <!-- title name -->

    <!-- inlcuded Booststrap CSS file -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- inlcuded JQuery file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h3>Linking Huts CRUD project</h3>
        <p id="res_panel">Click on the button and proceed </p>
        <button id="NewModal" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Add Employee
        </button>
    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Employee Record</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="submitForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 mt-3">
                            <input type="hidden" name="id", id="id">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" id="first_name" placeholder="Enter First Name"
                                name="first_name">
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name"
                                name="last_name">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter email"
                                name="email">
                        </div>
                        <div class="mb-3">
                            <label for="mobile">Mobile:</label>
                            <input type="text" class="form-control" id="mobile" placeholder="Enter Mobile"
                                name="mobile">
                        </div>
                        <div class="mb-3">
                            <label for="profile_photo">Profile Photo:</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>

                </div>
                </form>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <!-- Table for fetch record -->
    <div class="container my-3">
        <h2 class="mb-4">All Employee Record</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Photo</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody id="employee_data">
                    <!-- Fetch all employee table data here,-->
                </tbody>
            </table>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //Save/Add user data
        $(document).ready(function() {

            $('#NewModal').on('click', function() {
                $('#submitForm')[0].reset();
                $('.btn-success').text('Submit');
            });


            $('#submitForm').on('submit', function(e) {
                e.preventDefault();

                // Create a FormData object to handle file uploads
                var formData = new FormData(this);

                $.ajax({
                    url: "savedata",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#res_panel').html(response);
                        $('#submitForm')[0].reset();
                        $('#myModal').modal('hide');
                        fetchRecord();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: ", xhr.responseText); // Log detailed error
                        alert("Something went wrong! Please try again.");
                    }
                });

            });

        });


        //Update user data
        $(document).on('click', '.btn-warning', function(e) {
            e.preventDefault();
            var id = $(this).val();

            $.ajax({
                url: 'editdata',
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    $('#submitForm')[0].reset();
                    $('#id').val(response.id);
                    $('#first_name').val(response.first_name);
                    $('#last_name').val(response.last_name);
                    $('#email').val(response.email);
                    $('#mobile').val(response.mobile);
                    $('.btn-success').text('Update');
                    $('#myModal').modal('show');

                }
            });

        });

        //Delete user data
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).val();
            var confirmed = confirm("Are you sure you want to delete?");
            if (confirmed) {
                $.ajax({
                    url: 'deletedata',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        $("#res_panel").html(response);
                        fetchRecord(); // display the record after changes made, called the function
                    }
                });

            }

        });


        //Fetch all user data
        function fetchRecord() {
            $.ajax({
                url: "getdata", // url from where get the data
                type: 'GET',
                success: function(response) {
                    var tr = ''; // Initialize empty string for rows

                    // Loop through the response array
                    for (var i = 0; i < response.length; i++) {
                        var id = response[i].id;
                        var first_name = response[i].first_name;
                        var last_name = response[i].last_name;
                        var email = response[i].email;
                        var mobile = response[i].mobile;

                        // Add a table row for each record
                        tr += '<tr>';
                        tr += '<td>' + id + '</td>';
                        tr += '<td>' + first_name + '</td>';
                        tr += '<td>' + last_name + '</td>';
                        tr += '<td>' + email + '</td>';
                        tr += '<td>' + mobile + '</td>';
                        tr += '<td><img src="' + response[i].profile_photo +
                            '" alt="Photo" class="img-fluid" width="70" height="70"></td>'; // photo display in UI
                        tr += '<td> <button type="button" class="btn btn-warning edit-btn" value="' + id +
                            '">Edit</button> ' +
                            '<button type="button" class="btn btn-danger delete-btn" value="' + id +
                            '">Delete</button> </td> '; //edit and delete buttons

                        tr += '</tr>';
                    }

                    // Append rows to the table body
                    $('#employee_data').html(tr);
                },

            });
        }

        fetchRecord(); // display the record after changes made, called the function
    </script>
</body>

</html>
