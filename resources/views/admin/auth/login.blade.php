<!DOCTYPE html>
<!--[if IE 9]>
<html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus"> <!--<![endif]-->
<head>
    @include('admin.includes.headerfiles')
</head>
<body>
<!-- Login Content -->
<div class="content overflow-hidden">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
            <!-- Login Block -->
            <div class="block block-themed animated fadeIn">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        {{--<li>
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </li>--}}
                        {{--<li>
                            <a href="base_pages_register.html" data-toggle="tooltip" data-placement="left"
                               title="New Account"><i class="si si-plus"></i></a>
                        </li>--}}
                    </ul>
                    <h3 class="block-title">Login</h3>
                </div>
                <div class="block-content block-content-full block-content-narrow">
                    <!-- Login Title -->
                    <h1 class="h3 font-w600 push-30-t push-5">{{config('app.name')}}</h1>
                    <p>Welcome, please login.</p>
                    <!-- END Login Title -->

                    <!-- Login Form -->
                    <!-- jQuery Validation (.js-validation-login class is initialized in js/pages/base_pages_login.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-login form-horizontal push-30-t push-50" method="POST"
                          action="{{ route('login') }}">
                        @csrf
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="email" id="login-email" name="email"
                                           value="{{ old('email') }}"
                                           autocomplete="false" required>
                                    <label for="login-email">Email</label>
                                </div>
                                @if ($errors->has('email'))
                                    <div id="login-email-error"
                                         class="help-block text-right animated fadeInDown">{{ $errors->first('email') }}
                                    </div>
                                @endif


                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="form-material form-material-primary floating">
                                    <input class="form-control" type="password" id="login-password" name="password"
                                           autocomplete="new-password" required>
                                    <label for="login-password">Password</label>
                                </div>
                                @if ($errors->has('password'))
                                    <div id="login-password-error" class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="css-input switch switch-sm switch-primary">
                                    <input type="checkbox" id="login-remember-me"
                                           name="remember" {{ old('remember') ? 'checked' : '' }}><span></span>
                                    Remember Me?
                                </label>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <button class="btn btn-block btn-primary" type="submit"><i
                                            class="si si-login pull-right"></i> Log in
                                </button>
                            </div>
                        </div>
                    </form>


                    <!-- END Login Form -->
                </div>
            </div>
            <!-- END Login Block -->
        </div>
    </div>
</div>
<!-- END Login Content -->

<!-- Login Footer -->
<div class="push-10-t text-center animated fadeInUp">
    <small class="text-muted font-w600"><span class="js-year-copy"></span> &copy; {{config('app.name')}}</small>
</div>
<!-- END Login Footer -->

<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
@include('admin.includes.footerfiles')

<!-- Page JS Plugins -->
<script src="{{asset('admin_assets/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>

<!-- Page JS Code -->
<script src="{{asset('admin_assets/js/pages/base_pages_login.js')}}"></script>
<script>
    // Initialize when page loads
    jQuery(function () {
        BasePagesLogin.init();
    });
</script>
</body>
</html>