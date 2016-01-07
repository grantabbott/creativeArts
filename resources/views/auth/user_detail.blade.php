					<div class="media">
						<a class="pull-left" href="#fakelink">
							{!! \App\Classes\Helper::getAvatar($user->id) !!}
						</a>
						<div class="media-body" >
							@if(isset($welcome))
							{!! trans('messages.Welcome back') !!},
							@endif
							@if(isset($name))
							<h4 class="media-heading"><strong>{!! ($user->name) ? ucwords($user->name) : ucwords($user->username) !!}</strong></h4>
							@endif
							@if(isset($role))
							<span>
								@foreach($user->roles as $role)
									<strong>{!! $role->display_name !!}</strong>
								@endforeach
							</span><br />
							@endif
							@if(isset($email))
							<span>{!! $user->email !!}</span><br />
							@endif
							@if(isset($edit_profile))
							<a class="md-trigger" href="{!! URL::to('/user/'.Auth::user()->id) !!}">Edit Profile</a> <br />
							@endif
							@if(isset($logout))
							<a class="md-trigger" href="{!! URL::to('/logout') !!}">Logout</a> <br />
							@endif
							@if(isset($last_login))
							<a href="#">{!! trans('messages.Last Login') !!} <br />{!! App\Classes\Helper::showDateTime($user->last_login) !!} from {!! $user->last_login_ip !!}</a>
							@endif
						</div>
					</div>