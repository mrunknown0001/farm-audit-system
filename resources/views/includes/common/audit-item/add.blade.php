@extends('layouts.app')

@section('title')
	Add Audit Item
@endsection

@section('style')

@endsection

@section('sidebar')
	@if(Auth::User()->role_id == 2 || Auth::User()->role_id == 1)
		@include('admin.includes.sidebar')
	@elseif(Auth::User()->role_id == 3)
		@include('vp.includes.sidebar')
	@elseif(Auth::User()->role_id == 4)
		@include('divhead.includes.sidebar')
	@elseif(Auth::User()->role_id == 5)
		@include('manager.includes.sidebar')
	@elseif(Auth::User()->role_id == 6)
		@include('supervisor.includes.sidebar')
	@elseif(Auth::User()->role_id == 7)
		@include('officer.includes.sidebar')
	@elseif(Auth::User()->role_id == 8)
		@include('user.includes.sidebar')
	@endif
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Add Audit Item</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('audit.item') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Audit Items</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<form id="audititemform" action="{{ route('audit.item.post.add') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<div class="form-group {{ $errors->first('farm') ? 'has-error' : ''  }}">
						<label for="farm">Farm</label>
						<select name="farm" id="farm" class="form-control" required>
							<option value="">Select Farm</option>
							@foreach($farms as $key => $n)
								<option value="{{ $n->id }}">{{ $n->name }}</option>
							@endforeach
						</select>
						@if($errors->first('farm'))
            	<span class="help-block"><strong>{{ $errors->first('farm') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('audit_name') ? 'has-error' : ''  }}">
						<label for="audit_name">Audit Name</label>
						<select name="audit_name" id="audit_name" class="form-control" required>
							<option value="">Select Audit Name</option>
							@foreach($names as $key => $n)
								<option value="{{ $n->id }}">{{ $n->category_name }}</option>
							@endforeach
						</select>
						@if($errors->first('audit_name'))
            	<span class="help-block"><strong>{{ $errors->first('audit_name') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('audit_item_name') ? 'has-error' : ''  }}">
						<label for="audit_item_name">Audit Item</label>
						<input type="text" name="audit_item_name" id="audit_item_name" placeholder="Audit Item Name" class="form-control" required>
						@if($errors->first('audit_item_name'))
            	<span class="help-block"><strong>{{ $errors->first('audit_item_name') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('description') ? 'has-error' : ''  }}">
						<label for="description">Description</label>
						<textarea class="form-control" id="description" name="description"></textarea>
						@if($errors->first('description'))
            	<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('time_range') ? 'has-error' : ''  }}">
						<label for="time_range">Time Range <i>(24 Hour Time Format)</i></label> <button id="addTimeRange" type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
						{{-- <input type="text" name="time_range" id="time_range" placeholder="Example: 8am-9am, 5pm-6pm" class="form-control" required> --}}
						<div id="time_range_div">
							<div class="row form-group">
								<div class="col-md-2">
									<select name="from_hour[]" id="from_hour0" class=form-control required>
										<option value="">Hour</option>
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
									</select>
								</div>
								<div class="col-md-2">
									<select name="from_minute[]" id="from_minute0" class="form-control" required>
										<option value="">Minute</option>
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
										<option value="32">32</option>
										<option value="33">33</option>
										<option value="34">34</option>
										<option value="35">35</option>
										<option value="36">36</option>
										<option value="37">37</option>
										<option value="38">38</option>
										<option value="39">39</option>
										<option value="40">40</option>
										<option value="41">41</option>
										<option value="42">42</option>
										<option value="43">43</option>
										<option value="44">44</option>
										<option value="45">45</option>
										<option value="46">46</option>
										<option value="47">47</option>
										<option value="48">48</option>
										<option value="49">49</option>
										<option value="50">50</option>
										<option value="51">51</option>
										<option value="52">52</option>
										<option value="53">53</option>
										<option value="54">54</option>
										<option value="55">55</option>
										<option value="56">56</option>
										<option value="57">57</option>
										<option value="58">58</option>
										<option value="59">59</option>
									</select>
								</div>
								<div class="col-md-1">
									TO
								</div>
								<div class="col-md-2">
									<select name="to_hour[]" id="to_hour0" class=form-control required>
										<option value="">Hour</option>
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
									</select>
								</div>
								<div class="col-md-2">
									<select name="to_minute[]" id="to_minute0" class="form-control" required>
										<option value="">Minute</option>
										<option value="00">00</option>
										<option value="01">01</option>
										<option value="02">02</option>
										<option value="03">03</option>
										<option value="04">04</option>
										<option value="05">05</option>
										<option value="06">06</option>
										<option value="07">07</option>
										<option value="08">08</option>
										<option value="09">09</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
										<option value="32">32</option>
										<option value="33">33</option>
										<option value="34">34</option>
										<option value="35">35</option>
										<option value="36">36</option>
										<option value="37">37</option>
										<option value="38">38</option>
										<option value="39">39</option>
										<option value="40">40</option>
										<option value="41">41</option>
										<option value="42">42</option>
										<option value="43">43</option>
										<option value="44">44</option>
										<option value="45">45</option>
										<option value="46">46</option>
										<option value="47">47</option>
										<option value="48">48</option>
										<option value="49">49</option>
										<option value="50">50</option>
										<option value="51">51</option>
										<option value="52">52</option>
										<option value="53">53</option>
										<option value="54">54</option>
										<option value="55">55</option>
										<option value="56">56</option>
										<option value="57">57</option>
										<option value="58">58</option>
										<option value="59">59</option>
									</select>
								</div>
							</div>
						</div>
						@if($errors->first('time_range'))
            	<span class="help-block"><strong>{{ $errors->first('time_range') }}</strong></span>
            @endif
					</div>
					{{-- Removed for Singe Item Fucntion --}}
					{{-- <div class="form-group" id="items">
						<p><label>Checklist</label> <button id="addChecklist" type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></button></p>
					</div> --}}
					<div class="form-group">
						<h3>Locations Applied</h3>
						{{-- @if(count($locations) > 0)
							<div class="row"> 
								@foreach($locations as $key => $l)
									<div class="col-md-3"><input type="checkbox" name="locations[]" id="location{{ $l->id }}" value="{{ $l->id }}"> <label for="location{{ $l->id }}">{{ $l->location_name }}</label></div>
								@endforeach
							</div>
						@else
							<p>No Location Found!</p>
						@endif --}}
						<div class="row" id="locationsdiv"></div>
					</div>
					<div class="form-group">
						<button class="btn btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			var id=1;
			var id2=1;
			$("#addChecklist").click(function (e) {
				id += 1;
			  $("#items").append('<div id="itemrow' + id + '" class="itemrowclass row form-group"><div class="col-md-11"><input class="form-control" name="checklist[]" placeholder="Audit Item Checklist" required/></div><div class="col-md-1"><button type="button" class="btn btn-danger" onclick="remove(' + id + ')"><i class="fa fa-times-circle"></i></button></div></div>');
			});

			$("#addTimeRange").click(function (e) {
				
				$("#time_range_div").append('<div id="timerange' + id2 + '" class="row form-group timerangeclass"><div class="col-md-2 form-group"><select name="from_hour[]" required id="from_hour' + id2 + '" class=form-control><option value=""> Hour</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option>									<option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option>									<option value="16">16</option><option value="17">17</option><option value="18">18</option>									<option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select></div><div class="col-md-2 form-group"><select name="from_minute[]" required id="from_minute' + id2 + '" class="form-control"><option value=""> Minute</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select></div><div class="col-md-1">TO</div><div class="col-md-2"><select name="to_hour[]" id="to_hour' + id2 + '" class=form-control required><option value="">Hour</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select></div><div class="col-md-2"><select name="to_minute[]" id="to_minute' + id2 + '" class="form-control" required><option value="">Minute</option><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select></div><div class="col-md-2 form-group"><button type="button" class="btn btn-danger" onclick="removeTimeRange(' + id2 + ')"><i class="fa fa-times-circle"></i></button></div></div>'
				);
				id2 += 1;
			});
			


	  $('#audititemform').on('submit',(function(e) {
	    e.preventDefault();

			// Add Loading Animation here
	  	$("body").addClass("loading"); 
	    var formData = new FormData(this);
	    $.ajax({
	      type:'POST',
	      url: $(this).attr('action'),
	      data:formData,
	      cache:false,
	      contentType: false,
	      processData: false,
	      success:function(data){
	        // console.log("success");
	        console.log(data);
	        // Close Upload Animation here
	        $("body").removeClass("loading");
	        Swal.fire({
	          title: 'Audit Item Added!',
	          text: "",
	          type: 'success',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
	        // Clear Form
	        $("#audititemform").trigger("reset");
	        $(".itemrowclass").remove();
	        $("#locationsdiv").children("div").remove();
	        $(".timerangeclass").remove();

	      },
	      error: function(data){
	        // console.log(data.responseJSON);
	        var text = JSON.stringify(data.responseJSON.responseJSON);
	        $("body").removeClass("loading");
		      Swal.fire({
					  type: 'error',
					  title: 'Error Occured',
					  text: 'Please Try Again. ' + text,
					});
	      }
	    });
	  }));


	  $('#farm').change(function() {
	  	// locationsdiv
	  	var id = $(this).val();
	  	$.ajax({
				type:'get',
	      url: '/location/farm/' + id,
	      success: function(data) {
	      	// console.log(data);
	      	if(data == '') {
	      		$('#locationsdiv').append('<p class="locationappend text-center">No Location Found!</p>')
	      	}
	      	else {
	      		$('.locationappend').remove();
		      	$.each(data, function(k, v) {
					  	$('#locationsdiv').append('<div class="locationappend col-md-3"><input type="checkbox" name="locations[]" id="location' + data[k]['id'] +'" value="' + data[k]['id'] +'"> <label for="location' + data[k]['id'] +'">' + data[k]['name'] +'</label></div>');
					  });
		      }
	      },
	      error: function(data) {
	      	console.log(data)
	      }		
	  	})
	  });



		});

		function remove(id){
			did = '#itemrow' + id
			// console.log(did)
			$(did).remove();
		}

		function removeTimeRange(id){
			did = '#timerange' + id
			// console.log(did)
			$(did).remove();
		}
	</script>
@endsection