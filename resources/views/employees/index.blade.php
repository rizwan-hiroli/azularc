@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Employees</div>
                <!-- Alert for Success Message -->
                @if (session('success'))
                    <div style="padding:10px">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close pull-right" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>  
                @endif
                <div class="card-body">
                    <div class="container">
                        <!-- Row for alignment -->
                        <div class="row">
                            <!-- Column for button alignment -->
                            <div class="col d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Email</th>
                                    <th>Date of Birth</th>
                                    <th>Address</th>
                                    <th>Photo</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->age }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->date_of_birth ? $employee->date_of_birth : '' }}</td>
                                        <td>{{ $employee->address }}</td>
                                        <td>
                                            @if ($employee->photo)
                                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Photo" width="100">
                                            @else
                                                NA
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-edit" 
                                                    data-id="{{ $employee->id }}"
                                                    data-name="{{ $employee->name }}"
                                                    data-age="{{ $employee->age }}"
                                                    data-email="{{ $employee->email }}"
                                                    data-date_of_birth="{{ $employee->date_of_birth ? $employee->date_of_birth : '' }}"
                                                    data-address="{{ $employee->address }}"
                                                    data-photo="{{ $employee->photo }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        {{ $employees->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                <button type="button" class="close" style="position: absolute;top: 0;right: 0;margin: 1rem;" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required pattern="[A-Za-z\s]+">
                        <small class="form-text text-muted">Only alphabets and spaces are allowed.</small>
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Existing content -->

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                <button type="button" class="close" style="position: absolute;top: 0;right: 0;margin: 1rem;" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEmployeeForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required pattern="[A-Za-z\s]+">
                        <small class="form-text text-muted">Only alphabets and spaces are allowed.</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_age">Age</label>
                        <input type="number" name="age" id="edit_age" class="form-control" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_date_of_birth">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="edit_date_of_birth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <textarea name="address" id="edit_address" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_photo">Photo</label>
                        <input type="file" name="photo" id="edit_photo" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Attach click event to the edit buttons
        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var age = $(this).data('age');
            var email = $(this).data('email');
            var date_of_birth = $(this).data('date_of_birth');
            var address = $(this).data('address');
            var photo = $(this).data('photo');

            // Set form action URL
            $('#editEmployeeForm').attr('action', '/employees/' + id);

            // Populate form fields
            $('#edit_name').val(name);
            $('#edit_age').val(age);
            $('#edit_email').val(email);
            $('#edit_date_of_birth').val(date_of_birth);
            $('#edit_address').val(address);
            if (photo) {
                // $('#edit_photo').val(photo); // You might want to handle photo display separately
            }

            $('#editEmployeeModal').modal('show');
        });
    });
</script>


@endsection