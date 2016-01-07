@extends('layouts.install')

	@section('content')
		<a class="btn btn-primary btn-sm pull-right" style='margin:15px;' role="button" href="http://ticket-doc.wmlab.in" target=_blank>Documentation</a>
		<a class="btn btn-success btn-sm pull-right" style='margin:15px;' role="button" href="https://www.youtube.com/watch?v=6NvqWoIPOKs" target=_blank>Installation Video</a>
		<div class="full-content-center-more animated fadeInDownBig">
			<div class="login-wrap">
				<div class="box-info full">
				
				
					{!! Form::open(['route' => 'install.store','class' => 'install-form','id' => 'myWizard'])!!}
					<section class="step" data-step-title="Installation Guide">
							<div class="row">
								<div class="col-sm-12">
									<p>Hello Everybody!! Thanks for being my customer. I will guide you how to install this application's <strong>version {!! config('constants.VERSION') !!}</strong>. </p>
									<p>Lets check does your system fulfill the requirements of this application!! If you get this screen by navigating through /install, it means you have done completed most of the things.</p>
									<ol>
										<li>PHP Version >= 5.5.9</li>
										<li>OpenSSL PHP Extension</li>
										<li>PDO PHP Extension</li>
										<li>Mbstring PHP Extension</li>
										<li>Tokenizer PHP Extension</li>
										<li>Apache Rewrite Module Enabled</li>
									</ol>
								</div>
							</div>
					</section>
					<section class="step" data-step-title="Let's Get Ready">
							<div class="row">
								<div class="col-sm-12">
									<p>Once you think that your system has all the requirements. Next step is be ready with these stuffs.</p>
									<ol>
										<li>Create a MYSQL database & get ready with its username & Password</li>
										<li>Envato Username & Purchase License Code</li>
									</ol>
								</div>
							</div>
					</section>
					<section class="step" data-step-title="Let's Install">
							<div class="row">
								<h2><strong>I am ready with all!!</strong></h2>
								<div class="col-sm-6">
								  <div class="form-group">
									{!! Form::input('text','hostname','',['class'=>'form-control','placeholder'=>'Enter Hostname'])!!}
								  </div>
								  <div class="form-group">
									{!! Form::input('text','mysql_username','',['class'=>'form-control','placeholder'=>'Enter MYSQL Username'])!!}
								  </div>
								  <div class="form-group">
									{!! Form::input('password','mysql_password','',['class'=>'form-control','placeholder'=>'Enter MYSQL Password'])!!}
								  </div>
								  <div class="form-group">
									{!! Form::input('text','mysql_database','',['class'=>'form-control','placeholder'=>'Enter MYSQL Database'])!!}
								  </div>
								  <div class="form-group">
									{!! Form::input('email','email','',['class'=>'form-control','placeholder'=>'Enter Email'])!!}
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									{!! Form::input('text','username','',['class'=>'form-control','placeholder'=>'Enter Username'])!!}
								  </div>
								  <div class="form-group">
									{!! Form::input('password','password','',['class'=>'form-control','placeholder'=>'Enter Password'])!!}
								  </div>
								  <div class="form-group">
									{!! Form::input('text','envato_username','',['class'=>'form-control','placeholder'=>'Enter Envato Username'])!!}
								  </div>
								  <div class="form-group">
									{!! Form::input('text','purchase_code','',['class'=>'form-control','placeholder'=>'Enter Purchase Code'])!!}
								  </div>
								  <div class="form-group">
								  	<div class="checkbox">
										<label>
										  <input type="checkbox" name="installation_path" value="disabled"> Disable Installation Link After Successfully Installation
										</label>
									</div>
								  </div>
								  {!! Form::submit('Install',['class' => 'btn btn-primary pull-right']) !!}
								</div>
								</div>
							</div>
					</section>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	@stop