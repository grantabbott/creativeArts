
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">{!! trans('messages.Edit Business Hour') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($business_hour,['method' => 'PATCH','route' => ['business_hour.update',$business_hour->id] ,'class' => 'business-hour-form']) !!}
			@include('business_hour._form', ['buttonText' => 'Update'])
		{!! Form::close() !!}
	</div>
	<script>
	$(function() {
  	 Validate.init();
    $('.timepicker').datetimepicker({
		autoclose: 1,
		pickerPosition: "bottom-left",
		startView: 1});
    });
	</script>
