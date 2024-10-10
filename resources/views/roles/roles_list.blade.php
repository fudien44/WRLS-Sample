@extends('layouts.auth')
@section('content')
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="h3 text-gray-800">Roles and Permissions</h6>
    </div>
    <div class="col-md-3">
    <button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#modalPayment">
        <i class="fas fa-fw fa-user-plus"></i> Create New
    </button>
</div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr align="center">
                          <th>Role</th>
                          <th>Action</th>

                         
                      </tr>
                  </thead>
                  
                  <tbody>
                      <tr>
                          <td align="center">admin</td>
                          <td align="center">
                            <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#modalPayment">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modalPayment">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                          </td>
                         
                      </tr>
                       
                  </tbody>
              </table>
          </div>
      </div>
  </div>




@endsection