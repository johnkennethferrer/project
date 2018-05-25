@extends('layouts.app')

<style type="text/css">
	.col-md-5 .form-control-lg {
		width: 100%;
	}

	.col-md-5 {
		margin: auto;
	}

	.col-md-5 .col-md-12 {
		height:350px;
	}
</style>

@section('content')
<div class="col-md-12 col-sm-12 col-lg-12">
	
	<div class="container">
		<div class="col-md-5 mt-2">
			<!-- <input type="text" name="" class="form-control-lg" placeholder="Employee ID" autofocus autocomplete="off"> -->

			<h1 class="display-4 time-in text-center"><strong>Time-in</strong></h1>
			<h1 class="display-4 time-out text-center" hidden><strong>Time-out</strong></h1>

			<div class="col-md-12 border">
				<img src=" {{ asset('storage/no_image.png') }}" class="form-control p-0" style="width:100%; height: 100%;">
			</div>
		</div>
	</div>

</div>

<div id="time"></div>

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
  }

  setInterval(showTime, 1000);
</script>


@endsection('content')