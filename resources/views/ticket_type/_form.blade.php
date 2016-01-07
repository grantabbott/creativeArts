
			  <div class="form-group">
			    {!! Form::label('ticket_type_name',trans('messages.Ticket Type'),[])!!}
				{!! Form::input('text','ticket_type_name',isset($ticket_type->ticket_type_name) ? $ticket_type->ticket_type_name : '',['class'=>'form-control','placeholder'=>'Enter Ticket Type'])!!}
			  </div>
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Add'),['class' => 'btn btn-primary']) !!}
