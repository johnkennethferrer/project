@extends('layouts.app') 

@section('content')

    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2"><a href="/roles">Roles/</a>Update role</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <!-- <a href="/user_roles" class="btn btn-sm btn-outline-success p-3">View Role User</a>
                <button class="btn btn-sm btn-outline-primary p-3" data-toggle="modal" data-target=".add-new-role">Add New Role</button> -->
              </div>
            </div>
          </div>

          <div class="container">
            <div class="col-md-7">
             
              <form method="post" action="{{ route('roles.update', [$role->id]) }}">
                <input type="hidden" name="_method" value="put">
                @csrf

                <div class="form-group">
                  <label for="role-name" class="col-form-label">Role Name:</label>
                  <input type="text" class="form-control" id="role-name" name="name" value="{{ $role->name }}" placeholder="Role name" required>
                </div>

                <div class="form-group">
                  <label for="role-description" class="col-form-label">Description:</label>
                  <textarea class="form-control" id="role-description" name="description" placeholder="Description" rows="3">{{ $role->description }}</textarea>
                </div>

                <div class="form-group">
                  <button class="btn btn-primary float-right" type="submit">Submit</button>
                </div>

              </form>

            </div>
          </div>
          
        </main>
      </div>
    </div>

@endsection