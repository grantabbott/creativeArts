
			  <div class="form-group">
			    {!! Form::label('page_title',trans('messages.Title'),[])!!}
				{!! Form::input('text','page_title',isset($page->page_title) ? $page->page_title : '',['class'=>'form-control','placeholder'=>'Enter Title'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('page_description',trans('messages.Description'),[])!!}
			    {!! Form::textarea('page_description',isset($page->page_description) ? $page->page_description : '',['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Enter Content'])!!}
			  </div>
			  <div class="form-group">
	            <div class="checkbox">
	            <label>
	              <input type="checkbox" name="published" value="1" {!! (isset($page->published) && $page->published) ? 'checked' : '' !!}> Published
	            </label>
	            <label>
	              <input type="checkbox" name="sign_in_only" value="1"  {!! (isset($page->sign_in_only) && $page->sign_in_only) ? 'checked' : '' !!}> Visible only to Sign-in User
	            </label>
	            </div>
	          </div>
			  	{{ App\Classes\Helper::getCustomFields('page-form',$custom_field_values) }}
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.Save'),['class' => 'btn btn-primary']) !!}
