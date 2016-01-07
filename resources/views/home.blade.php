@extends('layouts.full')

    @section('content')
        <div class="row">
            
            <div class="col-md-8">
                <div class="box-info">
                    <h2><strong>{!! config('page.homepage.title') !!}</strong>
                        <div class="additional-btn">
                            <a href="/create-ticket" class="btn btn-primary btn-sm"><i class="fa fa-ticket"></i> {!! trans('messages.Create Ticket') !!}</a>
                            <a href="/create-ticket" class="btn btn-primary btn-sm"><i class="fa fa-ticket"></i> {!! trans('messages.View Ticket Status') !!}</a>
                        </div>
                    </h2>
                    {!! config('page.homepage.description') !!}
                </div>
            </div>

            <div class="col-md-4">
                @if(count($annoucements))
                <div class="box-info">
                    <h2><strong>{!! trans('messages.Annoucement') !!}</strong></h2>
                    <div class="comment-widget" >
                        <ul class="media-list">
                        @foreach($annoucements as $annoucement)
                            <li class="media">
                                <div class="media-body danger">
                                  <h4>{!! $annoucement->annoucement_title !!}</h4>
                                  {!! $annoucement->annoucement_description !!}
                                  <p class="time"><i class="fa fa-clock-o"></i> {!! \App\Classes\Helper::showDateTime($annoucement->created_at) !!}</p>
                                </div> 
                            </li>   
                        @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="box-info">
                    <h2><strong>{!! (!Auth::check()) ? trans('messages.Log In') : trans('messages.My').' '.trans('messages.Profile') !!}</strong> </h2>

                    @if(!Auth::check())
                        <div class="login-wrap">
                            @include('auth.login_form')
                        </div>
                    @else
                        @if(config('config.email_activation') && !Auth::user()->confirmed)
                            <div class="alert alert-danger">Your email has not been confirmed. Please check your email Id and activation your account.<a href="/resend_activation">Click here</a> to resend activation mail.</div>
                        @endif

                        @include('auth.user_detail',['user' => Auth::user(),'edit_profile' => 1, 'name' => 1, 'welcome' => '1','email' => 1])

                        @if(!isset(Auth::user()->username))
                            <div class="alert alert-danger">You have not yet set your username. Enter desired username below.</div>
                            {!! Form::open(['route' => 'user.setUsername','role' => 'form', 'class'=>'username-form ']) !!}
                              <div class="form-group">
                                {!! Form::input('text','username','',['class'=>'form-control','placeholder'=>'Enter Desired Username'])!!}
                              </div>
                                {!! Form::submit(trans('messages.Save'),['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        @endif

                    @endif

                </div>
            </div>
        </div>
    @stop