@extends('layouts.auth')

@section('content')
<div class="row">
  <div class="card animated--fade-in" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
    <div class="card-header py-3" style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0; padding: 1rem 1.5rem;">
      <h1 style="font-size: 1.5rem; font-weight: 700; color: #4e73df;">User Accounts</h1>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Create New Account</button>
    </div>
    <div style="padding: 1.5rem;">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      {{-- <table class="table"> --}}
        <thead>
          <tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($user as $userRole)
            <tr>
                <td>{{ $userRole->lname }}</td>
                <td>{{ $userRole->fname }}</td>
                <td>{{ $userRole->email }}</td>
                <td>{{ $userRole->contactno }}</td>
                <td>{{ $userRole->role ? $userRole->role->rolename : 'No Role' }}</td>
                <td>
                <button class="btn btn-success" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModal" 
                        data-user_id="{{ $userRole->user_id }}" 
                        data-fname="{{ $userRole->fname }}" 
                        data-lname="{{ $userRole->lname }}" 
                        data-email="{{ $userRole->email }}" 
                        data-contactno="{{ $userRole->contactno }}" 
                        data-role_id="{{ $userRole->role ? $userRole->role->role_id : '' }}" 
                        data-rolename="{{ $userRole->role ? $userRole->role->rolename : '' }}">Update
                </button>

                <button class="btn btn-warning" 
                            data-bs-toggle="modal" 
                            data-bs-target="#changePasswordModal" 
                            data-user_id="{{ $userRole->user_id }}" 
                            data-fname="{{ $userRole->fname }}">
                            Change Password
                </button>

                    <form action="{{ route('roles.destroy', $userRole->user_id) }}" method="POST" style="display:inline;" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create New Account</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactno" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contactno" name="contactno" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="hidden" id="roleInput" name="role" required>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="roleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Role
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="roleDropdown">
                                @foreach($roles as $role)
                                    <li><a href="#" class="dropdown-item" onclick="setRole('{{ $role->role_id }}', '{{ $role->rolename }}')">{{ $role->rolename }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="confirmCreate(this)">Create</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Account</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateForm" method="POST" action="{{ url('roles/' . '{user_id}') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="updateUserId" name="user_id">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactno" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contactno" name="contactno" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="hidden" id="updateRoleInput" name="role" required>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="updateRoleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Role
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="updateRoleDropdown">
                                @foreach($roles as $role)
                                    <li><a href="#" class="dropdown-item" onclick="updateRole('{{ $role->role_id }}', '{{ $role->rolename }}')">{{ $role->rolename }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" method="POST" action="{{ route('roles.changePassword') }}">
                    @csrf
                    <input type="hidden" id="changePasswordUserId" name="user_id">
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmNewPassword" name="newPassword_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    function setRole(role_id, rolename) {
        document.getElementById('roleDropdown').textContent = rolename;
        document.getElementById('roleInput').value = role_id;
    }

    function updateRole(role_id, rolename) {
        document.getElementById('updateRoleDropdown').textContent = rolename;
        document.getElementById('updateRoleInput').value = role_id;
    }

    document.addEventListener('DOMContentLoaded', function () {
    const updateModal = document.getElementById('updateModal');  

        updateModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const user_id = button.getAttribute('data-user_id');
            const fname = button.getAttribute('data-fname');
            const lname = button.getAttribute('data-lname');
            const email = button.getAttribute('data-email');
            const contactno = button.getAttribute('data-contactno');
            const role_id = button.getAttribute('data-role_id');
            const rolename = button.getAttribute('data-rolename');

            updateModal.querySelector('input[name="fname"]').value = fname;
            updateModal.querySelector('input[name="lname"]').value = lname;
            updateModal.querySelector('input[name="email"]').value = email;
            updateModal.querySelector('input[name="contactno"]').value = contactno;
            updateModal.querySelector('input[name="role"]').value = role_id;
            updateModal.querySelector('#updateRoleDropdown').textContent = rolename;
            updateModal.querySelector('#updateUserId').value = user_id;

            updateModal.querySelector('form').action = `/roles/${user_id}`;

        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const changePasswordModal = document.getElementById('changePasswordModal');

        changePasswordModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const user_id = button.getAttribute('data-user_id');
            const fname = button.getAttribute('data-fname');

            changePasswordModal.querySelector('input[name="user_id"]').value = user_id;
        });
    });

    @if(Session::has('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ Session::get('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

        function confirmCreate(button) {
            const form = $(button).closest('form');
                    Swal.fire(
                        'Success!',
                        'The account has been created.',
                        'success'
                    );
        }
        function confirmDelete(button) {
            const form = $(button).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Deleted!',
                        'The account has been deleted.',
                        'success'
                    );
                }
            });
        }
        
</script>
@endsection

