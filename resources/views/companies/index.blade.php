@extends('layouts.app') 

@section('content')
    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2">Companies</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-primary p-3" data-toggle="modal" data-target=".bd-example-modal-lg">Add New Company</button>
                <button class="btn btn-sm btn-outline-success">Import</button>
              </div>
            </div>
          </div>

          <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1009" height="426" style="display: block; width: 1009px; height: 426px;"></canvas> -->
          <div class="container">
            <div class="table-responsive">
              <table class="table table-striped table-sm" id="companiesTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Company name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($companies as $company)
                  <tr>
                    <td>{{ $company->id }}</td>
                    <td>{{ $company->name }}</td>
                    <td><textarea rows="3" class="form-control" readonly disabled>{{ $company->description }}</textarea></td>
                    <td>
                      <?php 
                        if ($company->status == 1) {
                          echo '<span>Active</span>';
                        } else {
                          echo '<span>Inactive</span>';
                        }
                       ?>
                    </td>
                    <td>
                      <a class="btn btn-primary" href="/companies/{{$company->id}}/edit">Edit</a> &nbsp;
                      
                      <a 
                        class="btn btn-danger"  
                        href="#"
                            onclick="
                            var result = confirm('Are you sure do you want to delete the company?');
                                if( result ){
                                        event.preventDefault();
                                        document.getElementById('delete-form').submit();
                                }
                                    "
                                    >
                            Delete
                        </a>

                        <form id="delete-form" action="{{ route('companies.destroy', [$company->id]) }}" 
                          method="POST" style="display: none;">
                                  <input type="hidden" name="_method" value="delete">
                                  @csrf
                        </form>
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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new company</h5>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
            <label class="switch">
              <input type="checkbox">
              <span class="slider round"></span>
            </label>
          </div>

          <div class="modal-body">
            <form method="post" action="{{ route('companies.store') }}">
              @csrf

              <div class="form-group">
                <label for="company-name" class="col-form-label">Company name:</label>
                <input type="text" class="form-control" id="company-name" name="name" placeholder="Company name" required>
              </div>
              <div class="form-group">
                <label for="description-text" class="col-form-label">Description:</label>
                <textarea class="form-control" rows="6" id="description-text" name="description" placeholder="Description"></textarea>
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
          $('#companiesTable').DataTable();
      });
    </script>

@endsection