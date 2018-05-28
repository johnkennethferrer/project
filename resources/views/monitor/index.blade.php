@extends('layouts.app')

<style type="text/css">
	.col-md-5 .form-control-lg {
		width: 100%;
	}

	.col-md-5 {
		margin: auto;
	}

	.col-md-5 .col-md-12 {
		height:330px;
	}
</style>

@section('content')
<div class="col-md-12 col-sm-12 col-lg-12">
	
	<div class="container">
		<div class="col-md-5 mt-1">

			@include('partials.success')
			@include('partials.errors')
			
			<h1 class="active" id="time-in" style="text-align: center; font-size: 60px;"><strong>Time-in</strong></h1>
			<h1 class="" id="time-out" style="display:none; text-align: center; font-size: 60px;"><strong>Time-out</strong></h1>

			<div class="col-md-12 border">

				@if(empty($employee))
					<img src=" {{ asset('storage/no_image.png') }}" class="form-control p-0" style="width:100%; height: 100%;">
				@else
					<h1 class="text-center" id="employeeName">{{ $employee->last_name }}, {{ $employee->first_name}} {{ $employee->middle_name }}</h1>
					<img src=" {{ asset('storage/') }}/{{ $employee->avatar }}" id="defaultImage" class="form-control p-0" id="employeeImage" style="width:100%; height: 100%;">
				@endif
				<img src=" {{ asset('storage/no_image.png') }}" class="form-control p-0" id="removeImage" style="display:none; width:100%; height: 100%;">
				
				<h1 class="text-center"><strong><div id="time"></div></strong></h1>
				<h2 class="text-center"><strong><div id="date"></div></strong></h2>
				<br/>

				<br/>
				<form method="post" action="{{ route('time_in_out') }}">		
					@csrf
					<input type="hidden" name="val_in_out" value="1" id="time_in_out"> <!-- time in = 1 / time out = 2 -->
					<input type="text" name="employeeId" class="form-control-lg" placeholder="Employee ID" autofocus autocomplete="off" required>
				</form>
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
  function showTime() {
    var date = new Date(),
        utc = new Date(Date.UTC(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          date.getHours(),
          date.getMinutes(),
          date.getSeconds()
        ));

    document.getElementById('time').innerHTML = utc.toLocaleTimeString();
    document.getElementById('date').innerHTML = utc.toLocaleDateString();
  }

  setInterval(showTime, 1000);

  	function hideEmployee(){
  		$('#employeeImage').hide();
  		$('#employeeName').hide();
  		$('#defaultImage').hide();
		$('#removeImage').show();	
	}
	setTimeout(hideEmployee, 20000);


	document.onkeyup=function(e) {
	    if(e.which == 27) {
	    	var className = $('#time-in').attr('class');

	    	if ($('#time-in').attr('class')) {
	    		$("#time-in").removeClass("active");
		    	$("#time-out").addClass("active");
		    	$('#time-in').hide();
		    	$('#time-out').show();
		    	$('#time_in_out').val("2");
	    	} else {
	    		$("#time-out").removeClass("active");
		    	$("#time-in").addClass("active");
		    	$('#time-out').hide();
		    	$('#time-in').show();
		    	$('#time_in_out').val("1");
	    	}
	    	
	    }
	}
</script>


@endsection('content')