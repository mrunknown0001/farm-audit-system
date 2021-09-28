@if(session('error'))
	<div class="alert bg-danger text-center top-space">
		<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<b>{{ session('error') }}</b>
	</div>
@endif