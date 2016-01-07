
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">{!! trans('messages.Edit Ticket Type') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($ticket_type,['method' => 'PATCH','route' => ['ticket_type.update',$ticket_type->id] ,'class' => 'ticket-type-form']) !!}
			@include('ticket_type._form', ['buttonText' => 'Update'])
		{!! Form::close() !!}
	</div>
	<script>
	$(function() {
  	 Validate.init();
    });
	</script>
