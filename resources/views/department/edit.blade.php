
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">{!! trans('messages.Edit Department Name') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($department,['method' => 'PATCH','route' => ['department.update',$department->id] ,'class' => 'department-form']) !!}
			@include('department._form', ['buttonText' => 'Update'])
		{!! Form::close() !!}
	</div>
	<script>
	$(function() {
  	 Validate.init();
    });
	</script>
