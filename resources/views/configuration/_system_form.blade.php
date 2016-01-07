			<div class="col-sm-6">
			  <div class="form-group">
			    {!! Form::label('application_title',trans('messages.Application Title'),[])!!}
				{!! Form::input('text','application_title',(config('config.application_title')) ? : '',['class'=>'form-control','placeholder'=>'Enter Application Title'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('application_name',trans('messages.Application Name'),[])!!}
				{!! Form::input('text','application_name',(config('config.application_name')) ? : '',['class'=>'form-control','placeholder'=>'Enter Application Name'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('facebook_page_link','Facebook Page Link',[])!!}
				{!! Form::input('text','facebook_page_link',(config('config.facebook_page_link')) ? : '',['class'=>'form-control','placeholder'=>'Enter Facebook Page Link'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('twitter_page_link','Twitter Page Link',[])!!}
				{!! Form::input('text','twitter_page_link',(config('config.twitter_page_link')) ? : '',['class'=>'form-control','placeholder'=>'Enter Twitter Page Link'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('credit',trans('messages.Credit'),[])!!}
			    {!! Form::textarea('credit',(config('config.credit')) ? : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => 'Credit Content'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('enable_registration','Enable Registration',['class' => 'col-sm-6 control-label'])!!}
				  <div class="col-sm-6">
					    <div class="radio">
							<label>
								{!! Form::radio('enable_registration', 1, (config('config.enable_registration')) ? 'checked' : '') !!} Yes
							</label>
							<label>
								{!! Form::radio('enable_registration', 0, (!config('config.enable_registration')) ? 'checked' : '') !!} No
							</label>
						</div>
				  </div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('email_activation','Email Activation Required',['class' => 'col-sm-6 control-label'])!!}
				  <div class="col-sm-6">
					    <div class="radio">
							<label>
								{!! Form::radio('email_activation', 1, (config('config.email_activation')) ? 'checked' : '') !!} Yes
							</label>
							<label>
								{!! Form::radio('email_activation', 0, (!config('config.email_activation')) ? 'checked' : '') !!} No
							</label>
						</div>
				  </div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('show_business_hour','Show Business Hour Page',['class' => 'col-sm-6 control-label'])!!}
				  <div class="col-sm-6">
					    <div class="radio">
							<label>
								{!! Form::radio('show_business_hour', 1, (config('config.show_business_hour')) ? 'checked' : '') !!} Yes
							</label>
							<label>
								{!! Form::radio('show_business_hour', 0, (!config('config.show_business_hour')) ? 'checked' : '') !!} No
							</label>
						</div>
				  </div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('show_terms_and_conditions','Show T&C',['class' => 'col-sm-6 control-label'])!!}
				  <div class="col-sm-6">
					    <div class="radio">
							<label>
								{!! Form::radio('show_terms_and_conditions', 1, (config('config.show_terms_and_conditions')) ? 'checked' : '') !!} Yes
							</label>
							<label>
								{!! Form::radio('show_terms_and_conditions', 0, (!config('config.show_terms_and_conditions')) ? 'checked' : '') !!} No
							</label>
						</div>
				  </div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('show_datetime_in_footer','Show Date Time in footer',['class' => 'col-sm-6 control-label'])!!}
				  <div class="col-sm-6">
					    <div class="radio">
							<label>
								{!! Form::radio('show_datetime_in_footer', 1, (config('config.show_datetime_in_footer')) ? 'checked' : '') !!} Yes
							</label>
							<label>
								{!! Form::radio('show_datetime_in_footer', 0, (!config('config.show_datetime_in_footer')) ? 'checked' : '') !!} No
							</label>
						</div>
				  </div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('show_timezone_in_footer','Show Timezone in footer',['class' => 'col-sm-6 control-label'])!!}
				  <div class="col-sm-6">
					    <div class="radio">
							<label>
								{!! Form::radio('show_timezone_in_footer', 1, (config('config.show_timezone_in_footer')) ? 'checked' : '') !!} Yes
							</label>
							<label>
								{!! Form::radio('show_timezone_in_footer', 0, (!config('config.show_timezone_in_footer')) ? 'checked' : '') !!} No
							</label>
						</div>
				  </div>
			  </div>
			</div>
			<div class="col-sm-6">
			  <div class="form-group">
			    {!! Form::label('error_display','Error Display',['class' => 'col-sm-4 control-label '])!!}
				<div class="col-sm-8">
					<div class="radio">
						<label>
							{!! Form::radio('error_display', true, (config('config.error_display')) ? 'checked' : '') !!} True
						</label>
						<label>
							{!! Form::radio('error_display', false, (!config('config.error_display')) ? 'checked' : '') !!} False
						</label>
					</div>
				</div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('date_format','Date format',['class' => 'col-sm-4 control-label'])!!}
				<div class="col-sm-8">
					<div class="radio">
						<label>
							{!! Form::radio('date_format', 'dd mm YYYY', (config('config.date_format') == 'dd mm YYYY') ? 'checked' : '') !!} dd mm YYYY ({!! date('d m Y') !!})
						</label>
					</div>
					<div class="radio">
						<label>
							{!! Form::radio('date_format', 'mm dd YYYY', (config('config.date_format') == 'mm dd YYYY') ? 'checked' : '') !!} mm dd YYYY ({!! date('m d Y') !!})
						</label>
					</div>
					<div class="radio">
						<label>
							{!! Form::radio('date_format', 'dd MM YYYY', (config('config.date_format') == 'dd MM YYYY') ? 'checked' : '') !!} dd MM YYYY ({!! date('d M Y') !!})
						</label>
					</div>
					<div class="radio">
						<label>
							{!! Form::radio('date_format', 'MM dd YYYY', (config('config.date_format') == 'MM dd YYYY') ? 'checked' : '') !!} MM dd YYYY ({!! date('M d Y') !!})
						</label>
					</div>
				</div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('time_format','Time format',['class' => 'col-sm-4 control-label'])!!}
				<div class="col-sm-8">
					<div class="radio">
						<label>
							{!! Form::radio('time_format', '24hrs', (config('config.time_format') == '24hrs') ? 'checked' : '') !!} 24 Hours
						</label>
						<label>
							{!! Form::radio('time_format', '12hrs', (config('config.time_format') == '12hrs') ? 'checked' : '') !!} 12 Hours
						</label>
					</div>
				</div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('installation_path','Install Path',['class' => 'col-sm-4 control-label'])!!}
				  <div class="col-sm-8">
					<div class="radio">
						<label>
							{!! Form::radio('installation_path', 1, (config('config.installation_path')) ? 'checked' : '') !!} Enable
						</label>
						<label>
							{!! Form::radio('installation_path', 0, (!config('config.installation_path')) ? 'checked' : '') !!} Disable
						</label>
					</div>
				  </div>
			  </div>
			  <div class="form-group">
			    {!! Form::label('timezone_id',trans('messages.Timezone'),[])!!}
				{!! Form::select('timezone_id', [null=>'Please Select'] + $timezones,(config('config.timezone_id')) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Timezone'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('default_currency',trans('messages.Default Currency'),[])!!}
				{!! Form::input('text','default_currency',(config('config.default_currency')) ? : '',['class'=>'form-control','placeholder'=>'Enter Default Currency'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('default_currency_symbol',trans('messages.Default Currency Symbol'),[])!!}
				{!! Form::input('text','default_currency_symbol',(config('config.default_currency_symbol')) ? : '',['class'=>'form-control','placeholder'=>'Enter Default Currency Symbol'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('default_language',trans('messages.Default Language'),[])!!}
				{!! Form::select('default_language', [null=>'Please Select'] + $languages,(config('config.default_language')) ? : 'en',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Language'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('direction',trans('messages.Direction'),[])!!}
				{!! Form::select('direction', ['ltr'=>'Left to Right',
					'rtl' => 'Right to Left'],(config('config.direction')) ? : '',['class'=>'form-control input-xlarge select2me','placeholder'=>'Select Timezone'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('allowed_upload_file',trans('messages.Default Upload File Type'),[])!!}
				{!! Form::input('text','allowed_upload_file',(config('config.allowed_upload_file')) ? : '',['class'=>'form-control','placeholder'=>'Enter Default Upload File Type'])!!}
			  	<p class="help-box">{!! trans('messages.File extension separated by comma') !!}</p>
			  </div>
			  <div class="form-group">
			    {!! Form::label('allowed_upload_max_size',trans('messages.Default Upload Fize Size'),[])!!}
				{!! Form::input('text','allowed_upload_max_size',(config('config.allowed_upload_max_size')) ? : '',['class'=>'form-control','placeholder'=>'Enter Default Upload Fize Size'])!!}
			  </div>
			  	{!! Form::hidden('config_type','system')!!}
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
			</div>
			<div class="clear"></div>