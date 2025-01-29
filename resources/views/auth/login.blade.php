<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Rumah Data 2.0" />
    <meta property="og:title" content="Rumah Data 2.0 - Admin Dashboard" />
    <meta property="og:description" content="Rumah Data 2.0 | Admin Dashboard" />
    <meta property="og:image" content="https://zenix.dexignzone.com/laravel/social-image.png" />
    <meta name="format-detection" content="telephone=no">
    <title>Rumah Data 2.0 Kota Samarinda</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    {{-- global style css --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />


</head>

<body class="vh-100">
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-1">
                                        <img src="{{asset('logo/bank_data_logo_login.png')}}" alt="">
                                    </div>
                                    <h4 class="text-center mb-2">Rumah Data</h4>
                                    <form action="{!! url('/index') !!}">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" value="hello@example.com">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" value="Password">
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox ms-1">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1">Remember my
                                                        preference</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="{!! url('/page-forgot-password') !!}">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary"
                                                href="{!! url('/page-register') !!}">Sign up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/global/global.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/deznav-init.js') }}" type="text/javascript"></script>
</body>

</html>
