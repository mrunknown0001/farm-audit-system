@if(session('info'))
	<div class="alert bg-info text-center top-space">
		<a href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<b>{{ session('info') }}</b>
	</div>
@endif