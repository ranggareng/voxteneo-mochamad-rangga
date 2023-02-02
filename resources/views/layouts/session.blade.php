@if(session('success'))
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> {!! session('success') !!}
	</div>				
@endif

@if(session('error'))
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> {!! session('error') !!}
	</div>				
@endif

@if(session('warning'))
	<div class="alert alert-warning alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> {!! session('warning') !!}
	</div>				
@endif

@if(count($errors))
<!-- <div class="alert alert-danger alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4><i class="icon fa fa-ban"></i> Oooppss!</h4>
	@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
</div> -->
@endif