@extends('layouts.default')

	@section('content')
		<div class="row">
        <div class="col-md-12">
            <div class="box box-solid box-primary">
				<div class="box-body">

					<div class="row">
						<div class="col-md-5">
							<ul class="ver-inline-menu tabbable margin-bottom-10">
								@foreach($templates as $key => $template)
								<li class="@if(head($templates) == $template) active @endif">
									<a data-toggle="tab" href="#tab_{!! $key !!}">
									<i class="fa fa-check"></i> {!! config('template.'.$key.'.title') !!} </a>
								</li>
								@endforeach
							</ul>
						</div>

						<div class="col-md-7">
							<div class="tab-content">
								@foreach($templates as $key => $template)
								<div id="tab_{!! $key !!}" class="tab-pane @if(head($templates) == $template) active @endif">
									<div id="accordion1" class="panel-group">
										<div class="panel panel-primary">
											<div class="panel-heading">
												<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1">
												Update "{!! config('template.'.$key.'.title') !!}" Template</a>
												<div class="additional-box pull-right">
													@if($template['category'] != 'system')
													{!! delete_form(['template.destroy',$key],trans('messages.Delete Template')) !!}
													@endif
													<a href="/template/create" class="btn btn-default btn-xs" data-toggle='modal' data-target='#myModal'>{!! trans('messages.Add New Template') !!}</a>
												</div>
												<div class="clear"></div>
												</h4>
											</div>
											<div id="accordion1_1" class="panel-collapse collapse in">
												<div class="panel-body">
													{!! Form::model($template,['method' => 'PATCH','route' => ['template.update',$key] ,'class' => '']) !!}
														
													  <div class="form-group">
													    {!! Form::label('template_subject',trans('messages.Subject'),[])!!}
														{!! Form::input('text','template_subject',config('template.'.$key.'.title'),['class'=>'form-control','placeholder'=>'Enter Subject','required' => 'true'])!!}
													  </div>
													  <div class="form-group">
													    {!! Form::label('template_description','Mail Body',[])!!}
													    {!! Form::textarea('template_description',(array_key_exists($key,$template_content)) ? $template_content[$key] : '',['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Description'])!!}
													  	<div class="help-block"><strong>Available Fields</strong> : {!! config('template.'.$key.'.fields') !!} <br /> Use all within [ ]. Fields are case sensitive.</div>
													  </div>
													  	{!! Form::submit(isset($buttonText) ? $buttonText : 'Save',['class' => 'btn btn-primary']) !!}

													{!! Form::close() !!}
												</div>
											</div>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

	@stop