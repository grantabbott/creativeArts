@extends('layouts.full')

    @section('content')
        <div class="full-content-center animated fadeInDownBig">
            <div class="login-wrap">
                <div class="box-info">
                <h2 class="text-center"><strong>{!! trans('messages.Create') !!}</strong> {!! trans('messages.Account') !!}</h2>
                    
                    @if ($errors->has())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {!! $error !!}<br>        
                        @endforeach
                    </div>
                    @endif
                    @if (session('success'))
                      <div class="alert alert-success">
                             {!! session('success') !!}
                      </div>
                    @endif

                    <form role="form" action="{!! URL::to('/user/register') !!}" method="post" class="register-form">
                        {!! csrf_field() !!}

                        <div class="form-group login-input">
                        <i class="fa fa-user overlay"></i>
                        <input type="text" name="name" id="name" class="form-control text-input" placeholder="Name">
                        </div>
                        <div class="form-group login-input">
                        <i class="fa fa-sign-in overlay"></i>
                        <input type="text" name="username" id="username" class="form-control text-input" placeholder="Username">
                        </div>
                        <div class="form-group login-input">
                        <i class="fa fa-envelope overlay"></i>
                        <input type="email" name="email" id="email" class="form-control text-input" placeholder="Email">
                        </div>
                        <div class="form-group login-input">
                        <i class="fa fa-key overlay"></i>
                        <input type="password" name="password" id="password" class="form-control text-input" placeholder="Password">
                        </div>
                        <div class="form-group login-input">
                        <i class="fa fa-eye overlay"></i>
                        <input type="password" name="password_confirmation" class="form-control text-input" placeholder="Confirm Password">
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-unlock"></i> {!! trans('messages.Register') !!}</button>
                            </div>
                        </div>
                    </form>
                    <p class="text-center"><a href="{!! URL::to('/') !!}"><i class="fa fa-lock"></i> {!! trans('messages.Back to login') !!}</a></p>
                </div>
            </div>
        </div>
    @stop