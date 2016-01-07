
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">{!! trans('messages.Edit Service Time') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($service_time,['method' => 'PATCH','route' => ['service_time.update',$service_time->id] ,'class' => 'service-time-form']) !!}
			@include('service_time._form', ['buttonText' => 'Update'])
		{!! Form::close() !!}
	</div>
	<script>
	$(function() {
  	 Validate.init();
    });
	</script>
