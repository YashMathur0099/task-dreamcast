<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Task Dreamcast</title>
</head>

<body>
    <div class="content-wrapper" id="addForm">
        <div class="content-body">
            <section class="bs-validation">
                {{-- <div class="col-6"> --}}
                    <div class="card align-items-center">
                        <div class="card-header">
                            <h4 class="card-title">User Form</h4>
                        </div>
                        <button type="button" id="listShow" class="btn btn-outline-primary m-2" onclick="show('list')">User List</button>
                        <div class="card-body">
                            <form id="userForm" class="needs-validation" novalidate enctype="multipart/form-data">
                                <div class="mb-1">
                                    <label class="form-label" for="basic-addon-name">Name</label>
                                    <input type="text" name="name" id="basic-addon-name" class="form-control"
                                        placeholder="Name" aria-label="Name" aria-describedby="basic-addon-name"
                                        required>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter name.</div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-default-email1">Email</label>
                                    <input type="email" name="email" id="basic-default-email1" class="form-control"
                                        placeholder="john.doe@email.com" aria-label="john.doe@email.com" required>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter a valid email</div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-default-password1">Phone</label>
                                    <input type="text" id="basic-default-password1" name="phone"
                                        class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        required>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter phone no.</div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="select-country1">Role</label>
                                    <select class="form-control form-select" name="role_id" id="select-country1" required>
                                        <option value="">Select Role</option>
                                        @foreach ($role as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please select role</div>
                                </div>
                                <div class="mb-1">
                                    <label for="customFile1" class="form-label">Profile pic</label>
                                    <input class="form-control" name="profile" type="file" id="customFile1" required>
                                </div>
                                <div class="mb-1">
                                    <label class="d-block form-label" for="validationBioBootstrap">Description</label>
                                    <textarea class="form-control" name="description" id="validationBioBootstrap" name="validationBioBootstrap"
                                        rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                {{-- </div> --}}
            </section>
        </div>
    </div>

    <div class="container" style="display: none" id="userList">
        <button type="button" class="btn btn-outline-primary m-2" onclick="show('add')">Add User</button>
        <table class="table" id="usersTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Role</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                <tr>

                </tr>
            </tbody>
        </table>
        <h3 id="noUsersMessage">List is empty</h3>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script>
        function show(type) {
            if( type === 'list') {
                document.getElementById('userList').style.display = '';
                document.getElementById('addForm').style.display = 'none';
            }

            if( type === 'add') {
                document.getElementById('addForm').style.display = '';
                document.getElementById('userList').style.display = 'none';
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("userForm");

            form.addEventListener("submit", function (event) {
                event.preventDefault();

                if (!form.checkValidity()) {
                    event.stopPropagation();
                    form.classList.add('was-validated');
                    return;
                }

                submitForm();
            });

            function submitForm() {
                const formData = new FormData(form);

                fetch('/api/user-add', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        const firstErrorField = Object.keys(data.errors)[0];
                        const firstErrorMessage = data.errors[firstErrorField][0];
                        console.log(firstErrorMessage)

                        alert("Error: " + firstErrorMessage);
                    } else {
                        alert("Form submitted successfully!");
                        form.reset();
                        form.classList.remove('was-validated');
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fetchUsersBtn = document.getElementById("listShow");
            const usersTable = document.getElementById("usersTable");
            const usersTableBody = document.getElementById("usersTableBody");
            const noUsersMessage = document.getElementById("noUsersMessage");

            function fetchUsers() {
                fetch('/api/user-lists')
                    .then(response => response.json())
                    .then(data => {
                        data = data.data;
                        console.log(data);
                        usersTableBody.innerHTML = '';

                        if (data.length > 0) {
                            usersTable.style.display = 'table';
                            noUsersMessage.style.display = 'none';

                            data.forEach(user => {
                                console.log(user);
                                const row = document.createElement("tr");

                                row.innerHTML = `
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.phone || 'N/A'}</td>
                                    <td>${user.role_data.name || 'N/A'}</td>
                                    <td>${user.description || 'N/A'}</td>
                                `;

                                usersTableBody.appendChild(row);
                            });
                        } else {
                            usersTable.style.display = 'none';
                            noUsersMessage.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                        alert("An error occurred while fetching users. Please try again.");
                    });
            }

            fetchUsersBtn.addEventListener('click', fetchUsers);
        });
    </script>
</body>

</html>
