@extends('layouts.app') 

@section('content')
    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2"><a href="/employees">Employees/</a><span>Update employee</span></h1>
          </div>

          <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1009" height="426" style="display: block; width: 1009px; height: 426px;"></canvas> -->
          <div class="container">
            <div class="row">
              
                <div class="col-md-9 mt-5">

                  <form method="post" action="{{ route('employees.update', [$employee->id]) }}">
                  <input type="hidden" name="_method" value="put">
                  @csrf
                  <div class="row">
                                         
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="id" class="col-form-label">Employee ID:</label>
                          <input type="text" class="form-control bg-white" id="id" value="{{ $employee->id }}" readonly disabled>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="company" class="col-form-label">Company:</label>
                          <!-- <input type="text" class="form-control bg-white" id="company" value="{{ $employee->name }}" readonly disabled> -->
                          <select class="custom-select form-control" name="company_id">
                            <option value="{{$employee->company_id}}" selected>{{ $employee->name }}</option>
                            @foreach($companies as $company)
                              <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="last-name" class="col-form-label">Last name:</label>
                          <input type="text" class="form-control bg-white" name="lname" id="last-name" value="{{ $employee->last_name }}" placeholder="Last name" required>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="first-name" class="col-form-label">First name:</label>
                          <input type="text" class="form-control bg-white" name="fname" id="first-name" value="{{ $employee->first_name }}" placeholder="First name" required>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="middle-name" class="col-form-label">Middle name:</label>
                          <input type="text" class="form-control bg-white" name="mname" id="middle-name" value="{{ $employee->middle_name }}" placeholder="Middle name">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="gender" class="col-form-label">Gender:</label>
                          <br/>
                          @if($employee->gender == "Male")
                            <label class="mr-3 ml-2">
                              <input type="radio" name="gender" checked value="1"> <span class="label-text">Male</span>
                            </label>
                            <label>
                              <input type="radio" name="gender" va1ue="2"> <span class="label-text">Female</span>
                            </label>
                          @else
                            <label class="mr-3 ml-2">
                              <input type="radio" name="gender" value="1"> <span class="label-text">Male</span>
                            </label>
                            <label>
                              <input type="radio" name="gender" checked va1ue="2"> <span class="label-text">Female</span>
                            </label>
                          @endif
                        </div>
                      </div>                

                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="address-text" class="col-form-label">Address:</label>
                          <textarea class="form-control bg-white" rows="3" name="address" id="address-text" placeholder="Address" required>{{ $employee->address }}</textarea>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="status-text" class="col-form-label">Status:</label>
                            <div class="form-group">
                              @if($employee->status == 1)
                                <label class="mr-3 ml-2">
                                  <input type="radio" name="status" checked value="1"> <span class="label-text">Active</span>
                                </label>
                                <label>
                                  <input type="radio" name="status" va1ue="2"> <span class="label-text">Inactive</span>
                                </label>
                              @else
                                <label class="mr-3 ml-2">
                                  <input type="radio" name="status" value="1"> <span class="label-text">Active</span>
                                </label>
                                <label>
                                  <input type="radio" name="status" checked va1ue="2"> <span class="label-text">Inactive</span>
                                </label>
                              @endif
                            
                            </div>
                        </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group float-right">
                            <button class="btn btn-primary float-right" type="submit">Submit</button>
                          </div>
                      </div>

                    </div>
                  </form>

                </div>

                  <div class="col-md-2">
                  <div class="col-md-12 border p-0" style="height:160px;">
                    @if($employee->avatar == null)
                      <img src=" {{ asset('storage/no_image.png') }}" class="form-control p-0" style="width:100%; height: 100%;">
                    @else
                      <img src=" {{ asset('storage/') }}/{{ $employee->avatar }}" class="form-control p-0" style="width:100%; height: 100%;">
                    @endif
                  </div>
                  <div class="col-md-12 mt-2 p-0">

                    <form method="post" action="{{ route('upload_image') }}" enctype="multipart/form-data" class="d-inline">
                      @csrf
                      <input type="hidden" name="employeeId" value="{{ $employee->id }}">
                      <input type="file" name="uploadImage" class="form-control" id="choose_file" style="display: none;" required>
                      <button class="btn btn-success mt-2" id="save_image" onclick="save_image()" style="display: none;">SAVE</button>
                    
                    </form>

                    <button class="btn btn-primary ml-5" id="edit_image" onclick="edit_image()">EDIT</button>
                    <button class="btn btn-danger mt-2" id="cancel_image" onclick="cancel_image()" style="display: none;">CANCEL</button>

                  </div>
                </div>

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
                <input type="text" class="form-control" id="company-name" name="name">
              </div>
              <div class="form-group">
                <label for="description-text" class="col-form-label">Description:</label>
                <textarea class="form-control" id="description-text" name="description"></textarea>
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

      //edit function
      function edit_image() {
        $("#save_image").show(500);
        $("#cancel_image").show(500);
        $('#choose_file').show(500);
        $("#edit_image").hide(500);
      }

      //cancel function
      function cancel_image() {
        $("#save_image").hide(500);
        $("#cancel_image").hide(500);
        $("#edit_image").show(500);
        $('#choose_file').hide(500);
      } 

    </script>

@endsection