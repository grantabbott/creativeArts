                    <form role="form" action="{!! URL::to('/login') !!}" method="post" class="login-form">
                        {!! csrf_field() !!}
                        <div class="form-group login-input">
                        <i class="fa fa-sign-in overlay"></i>
                        <input type="text" name="username" id="username" class="form-control text-input" placeholder="Username">
                        </div>
                        <div class="form-group login-input">
                        <i class="fa fa-key overlay"></i>
                        <input type="password" name="password" id="password" class="form-control text-input" placeholder="Password">
                        </div>
                        <div class="checkbox">
                        <label>
                            <input type="checkbox"> {!! trans('messages.Remember me') !!}
                        </label>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-unlock"></i> {!! trans('messages.Login') !!}</button>
                            </div>
                            @if(config('config.enable_registration'))
                            <div class="col-sm-6">
                            <a href="/register" class="btn btn-default btn-block"><i class="fa fa-user"></i> {!! trans('messages.Register') !!}</a>
                            </div>
                            @endif
                        </div>
                    </form>
                        <p class="text-center"><strong>- or -</strong></p>
                    
                    @if(config('config.facebook_login'))
                    <a href="{!! route('social.login', ['facebook']) !!}" class="btn btn-primary btn-block btn-facebook"><i class="fa fa-facebook"></i> Login with Facebook account</a>
                    @endif
                    @if(config('config.twitter_login'))
                    <a href="{!! route('social.login', ['twitter']) !!}" class="btn btn-primary btn-block btn-twitter"><i class="fa fa-twitter"></i> Login with Twitter account</a>
                    @endif
                    @if(config('config.google_login'))
                    <a href="{!! route('social.login', ['google']) !!}" class="btn btn-primary btn-block btn-google-plus"><i class="fa fa-google-plus"></i> Login with Google account</a>
                    @endif
                    @if(config('config.github_login'))
                    <a href="{!! route('social.login', ['github']) !!}" class="btn btn-primary btn-block btn-github"><i class="fa fa-github"></i> Login with Github account</a>
                    @endif

                    <p class="text-center"><a href="{!! URL::to('/password/email') !!}"><i class="fa fa-lock"></i> {!! trans('messages.Forgot password') !!}?</a></p>
                    