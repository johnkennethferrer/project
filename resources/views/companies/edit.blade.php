@extends('layouts.app') 

@section('content')
    <div class="container-fluid">
      <div class="row">
        
        @include('partials.sidebar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          @include('partials.errors')
          @include('partials.success') 

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h1 class="h2"><a href="/companies">Companies/</a><span>Update company</span></h1>
          </div>

          <!-- <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" width="1009" height="426" style="display: block; width: 1009px; height: 426px;"></canvas> -->
          <div class="container">
            <div class="col-md-7">
             
              <form method="post" action="{{ route('companies.update', [$company->id]) }}">
                <input type="hidden" name="_method" value="put">
                @csrf

                <div class="form-group">
                  <label for="company-name" class="col-form-label">Company name:</label>
                  <input type="text" class="form-control" id="company-name" name="name" value="{{ $company->name }}" placeholder="Company name" required>
                </div>

                <div class="form-group">
                  <label for="description-text" class="col-form-label">Description:</label>
                  <textarea class="form-control" rows="6" id="description-text" name="description" placeholder="Description" required>{{$company->description}}</textarea>
                </div>

                <div class="form-group">
                  <label for="status-text" class="col-form-label">Status:</label>
                    <div class="form-check">
                      @if($company->status == 1)
                        <label class="mr-5">
                          <input type="radio" name="status" checked value="1"> <span class="label-text">Active</span>
                        </label>
                        <label>
                          <input type="radio" name="status" va1ue="2"> <span class="label-text">Inactive</span>
                        </label>
                      @else
                        <label class="mr-5">
                          <input type="radio" name="status" value="1"> <span class="label-text">Active</span>
                        </label>
                        <label>
                          <input type="radio" name="status" checked va1ue="2"> <span class="label-text">Inactive</span>
                        </label>
                      @endif
                    
                    </div>
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