@extends('layouts.app') 

@section('content')

    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2"><a href="/roles">Roles/</a>User Roles</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-primary p-3" data-toggle="modal" data-target=".add-new-role">Add User Role</button>
              </div>
            </div>
          </div>

          <div class="container">
            <div class="">
              
              <div class="row">
                <div class="col-md-8">
                  <table class="table table-striped table-sm" id="roleTable">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($roleusers as $roleuser)
                      <tr>
                        <td>{{ $roleuser->id }}</td>
                        <td>{{ $roleuser->name}}</td>
                        <td>{{ $roleuser->rname}}</td>
                        <td>
                          <button class="btn btn-primary" data-toggle="modal" data-target=".editrole{{$roleuser->id}}">Edit</button>

                           <!-- Modal / add role a user -->
                          <div class="modal fade bd-example-modal-lg editrole{{$roleuser->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Edit role of user ID : {{$roleuser->id}}</h5>
                                </div>

                                <div class="modal-body">
                                  <form method="post" action="{{ route('edit_role_user') }}">
                                    <input type="hidden" name="_method" value="put">
                                    @csrf
                                    <input type="hidden" name="role_user_id" value="{{$roleuser->id}}">

                                    <div class="col-md-12">
                                      <div class="row">

                                        <div class="col-md-9">

                                          <div class="form-group">
                                            <label for="name" class="col-form-label">Name:</label>
                                            <input id="name" type="text" class="form-control bg-white" value="{{$roleuser->name}}" disabled readonly>
                                          </div>

                                          <div class="form-group">
                                            <label for="description" class="col-form-label"><span class="text-danger">(*) </span>Roles:</label>
                                            <select class="form-control" name="role_id" required>
                                              @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{ $role->name }}</option>
                                              @endforeach
                                            </select>
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
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <div class="col-md-4">
                  <h5 class="p-3 bg-danger text-white">No role users</h5>
                  <table class="table table-striped table-sm" id="roleTable2">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($noroles as $noroleuser)
                      <tr>
                        <td>{{ $noroleuser->id }}</td>
                        <td>{{ $noroleuser->name}}</td>
                        <td>
                          <button class="btn btn-primary" data-toggle="modal" data-target=".addrole{{$noroleuser->id}}">Add role</button>

                          <!-- Modal / add role a user -->
                          <div class="modal fade bd-example-modal-lg addrole{{$noroleuser->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Add role</h5>
                                </div>

                                <div class="modal-body">
                                  <form method="post" action="{{ route('add_role_user') }}">
                                    @csrf
                                    <input type="hidden" name="role_user_id" value="{{$noroleuser->id}}">

                                    <div class="col-md-12">
                                      <div class="row">

                                        <div class="col-md-9">

                                          <div class="form-group">
                                            <label for="name" class="col-form-label">Name:</label>
                                            <input id="name" type="text" class="form-control bg-white" value="{{$noroleuser->name}}" disabled readonly>
                                          </div>

                                          <div class="form-group">
                                            <label for="description" class="col-form-label"><span class="text-danger">(*) </span>Roles:</label>
                                            <select class="form-control" name="role_id" required>
                                              @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{ $role->name }}</option>
                                              @endforeach
                                            </select>
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

                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
          
        </main>
      </div>
    </div>
  
    <script> 
      $(document).ready( function () {
          $('#roleTable').DataTable();
          $('#roleTable2').DataTable();
      });
    </script>
@endsection