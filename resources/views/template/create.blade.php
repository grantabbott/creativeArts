
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">{!! trans('messages.Add New Template') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::open(['route' => 'template.store','role' => 'form', 'class'=>'template-form']) !!}
		  <div class="form-group">
		    {!! Form::label('category',trans('messages.Category'),['class' => 'control-label'])!!}
		    {!! Form::select('category', [null=>'Select One','ticket' => 'Ticket','user' => 'User'], '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Category'])!!}
		  </div>
		  <div class="form-group">
		    {!! Form::label('template_subject',trans('messages.Template Subject'),[])!!}
			{!! Form::input('text','template_subject','',['class'=>'form-control','placeholder'=>'Enter Template Subject'])!!}
		  </div>
		  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Add'),['class' => 'btn btn-primary']) !!}
		{!! Form::close() !!}
	</div>
	<script>
	$(function() {
  	 Validate.init();
    });
	</script>
