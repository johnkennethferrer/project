@extends('layouts.app') 

@section('content')

    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Roles</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <a href="/user_roles" class="btn btn-sm btn-outline-success p-3">View Role User</a>
                <button class="btn btn-sm btn-outline-primary p-3" data-toggle="modal" data-target=".add-new-role">Add New Role</button>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="roleTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($roles as $role)
                  <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->description }}</td>
                    <td>
                      <a class="btn btn-primary" href="/roles/{{$role->id}}/edit">Edit</a> &nbsp;
                      <a class="btn btn-danger" href="/">Delete</a> &nbsp;
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          
        </main>
      </div>
    </div>

    <!-- Modal / add new role -->
    <div class="modal fade bd-example-modal-lg add-new-role" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new role</h5>
          </div>

          <div class="modal-body">
            <form method="post" action="{{ route('roles.store') }}">
              @csrf

              <div class="col-md-12">
                <div class="row">

                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="name" class="col-form-label">Name:</label>
                      <input id="name" type="text" class="form-control" name="name" placeholder="Name" required>
                    </div>

                    <div class="form-group">
                      <label for="description" class="col-form-label">Description:</label>
                      <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"></textarea>
                    </div>
                  </div>

                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>
    <!--  End modal -->

  
    <script> 
      $(document).ready( function () {
          $('#roleTable').DataTable();
      });
    </script>
@endsection