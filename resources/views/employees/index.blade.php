@extends('layouts.app') 

@section('content')

    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Employees</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-primary p-3" data-toggle="modal" data-target=".add-new-employee">Add New Employee</button>
                <button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target=".import-csv">Import CSV file</button>
                <a href="{{ route('export_csv') }}" target="_blank" class="btn btn-sm btn-outline-secondary pt-3">Export all to CSV file</a>
              </div>
            </div>
          </div>

          <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1009" height="426" style="display: block; width: 1009px; height: 426px;"></canvas> -->
          <div class="container">
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="employeeTable">
                <thead>
                  <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Last name</th>
                    <th class="text-center">First name</th>
                    <th class="text-center">Middle name</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" width="120px">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($employees as $employee)
                  <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->last_name }}</td>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->middle_name }}</td>
                    <td>{{ $employee->gender}}</td>
                    <td><textarea rows="3" class="form-control" readonly disabled>{{ $employee->address }}</textarea></td>
                    <td>{{ $employee->name }}</td>
                    <td>
                      <?php 
                        if ($employee->status == 1) {
                          echo '<span>Active</span>';
                        } else {
                          echo '<span>Inactive</span>';
                        }
                       ?>
                    </td>
                    <td>
                      <a class="btn btn-success" href="/employees/{{$employee->id}}">View</a> &nbsp;
                      <a class="btn btn-primary" href="/employees/{{$employee->id}}/edit">Edit</a> &nbsp;
                      
                      <!-- <a 
                        class="btn btn-danger"  
                        href="#"
                            onclick="
                            var result = confirm('Are you sure do you want to delete the employee?');
                                if( result ){
                                        event.preventDefault();
                                        document.getElementById('delete-form').submit();
                                }
                                    "
                                    >
                            Delete
                        </a>

                        <form id="delete-form" action="{{ route('employees.destroy', [$employee->id]) }}" 
                          method="POST" style="display: none;">
                                <input type="hidden" name="_method" value="delete">
                                @csrf
                      </form> -->

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

    <!-- Modal // Add new employee -->
    <div class="modal fade bd-example-modal-lg add-new-employee" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new employee</h5>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
          </div>

          <div class="modal-body">
            <form method="post" action="{{ route('employees.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="col-md-12">
                <div class="row">

                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="avatar-name" class="col-form-label">Image:</label>
                      <input type="file" class="form-control" id="avatar-name" name="avatar">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="last-name" class="col-form-label">Last name:</label>
                      <input type="text" class="form-control" id="last-name" name="lname" placeholder="Last name" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="first-name" class="col-form-label">First name:</label>
                      <input type="text" class="form-control" id="first-name" name="fname" placeholder="First name" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="middle-name" class="col-form-label">Middle name:</label>
                      <input type="text" class="form-control" id="middle-name" name="mname" placeholder="Middle name">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="middle-name" class="col-form-label">Gender: </label>
                        <br/>
                        <label class="mr-3 ml-2">
                          <input type="radio" name="gender" checked value="1"> <span class="label-text">Male</span>
                        </label>
                        <label>
                          <input type="radio" name="gender" va1ue="2"> <span class="label-text">Female</span>
                        </label>                 
                    </div>
                  </div>

                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="address-text" class="col-form-label">Address:</label>
                      <textarea class="form-control" rows="2" id="address-text" name="address" placeholder="Address" required></textarea>
                    </div>
                  </div>

                  <div class="col-md-7">
                    <div class="form-group">
                      <label for="company-text" class="col-form-label">Company:</label>
                      <select class="form-control" name="company_id" required>
                        @foreach($companies as $company)
                          <option value="{{ $company->id }}">{{ $company->name }}</option>
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

    <!-- Modal / Import CSV file -->
    <div class="modal fade bd-example-modal-lg import-csv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
          </div>

          <div class="modal-body">
            <form method="post" action="{{ route('import_csv') }}" enctype="multipart/form-data">
              @csrf

              <div class="col-md-12">
                <div class="row">

                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="csv-file" class="col-form-label">File(.csv):</label>
                      <input id="csv-file" type="file" class="form-control" name="import_file">
                    </div>
                  </div>

                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Parse</button>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>
    <!--  End modal -->

    <script> 
      $(document).ready( function () {
          $('#employeeTable').DataTable();
      });
    </script>
@endsection