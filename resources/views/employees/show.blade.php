@extends('layouts.app') 

@section('content')
    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2"><a href="/employees">Employees/</a><span>View employee</span></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <a href="/employees/{{$employee->id}}/edit" class="btn btn-sm btn-outline-primary p-3 pl-5 pr-5">Edit</a>
                <a 
                  class="btn btn-sm btn-outline-danger p-3 pl-5 pr-5"  
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
                </form>
              </div>
            </div>
          </div>

          <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1009" height="426" style="display: block; width: 1009px; height: 426px;"></canvas> -->
          <div class="container">
            <div class="row">
              
                <div class="col-md-9 mt-5">

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
                          <input type="text" class="form-control bg-white" id="company" value="{{ $employee->name }}" readonly disabled>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="last-name" class="col-form-label">Last name:</label>
                          <input type="text" class="form-control bg-white" id="last-name" value="{{ $employee->last_name }}" readonly disabled>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="first-name" class="col-form-label">First name:</label>
                          <input type="text" class="form-control bg-white" id="first-name" value="{{ $employee->first_name }}" readonly disabled>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="middle-name" class="col-form-label">Middle name:</label>
                          <input type="text" class="form-control bg-white" id="middle-name" value="{{ $employee->middle_name }}" readonly disabled>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="gender" class="col-form-label">Gender:</label>
                          <input type="text" class="form-control bg-white" id="gender" value="{{ $employee->gender }}" readonly disabled>
                        </div>
                      </div>                

                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="address-text" class="col-form-label">Address:</label>
                          <textarea class="form-control bg-white" rows="3" id="address-text" readonly disabled>{{ $employee->address }}</textarea>
                        </div>
                      </div>

                    </div>

                  </div>

                  <div class="col-md-2">
                    <div class="col-md-12 border p-0" style="height:160px;">
                      @if($employee->avatar == null)
                        <img src=" {{ asset('storage/no_image.png') }}" class="form-control p-0" style="width:100%; height: 100%;">
                      @else
                        <img src=" {{ asset('storage/') }}/{{ $employee->avatar }}" class="form-control p-0" style="width:100%; height: 100%;">
                      @endif
                    </div>
                  </div>

            </div>            
          </div>
          
        </main>
      </div>
    </div>

@endsection