
    <!DOCTYPE html>
    <html lang="en" itemscope itemtype="http://schema.org/WebPage">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <link rel="icon" type="image/png" href="../assets/img/favicon.png">

        @vite('resources/css/app.css')
        <title>
            Login | Anecake
        </title>
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css"
            href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
        <!-- Nucleo Icons -->
        <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
        <!-- CSS Files -->
        <link id="pagestyle" href="{{asset('assets/css/material-kit.css?v=3.0.4')}}" rel="stylesheet" />
    </head>

    <body class="sign-in-basic">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');"
            loading="lazy">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center text-2xl mt-2 mb-2 ">Selamat Datang!</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" class="text-start" method="POST" action="{{ route('masuk') }}">
                                    @csrf
                                    <div class="input-group input-group-outline my-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Masuk</button>
                                    </div>
                                    <p class="mt-4 text-sm ">
                                        <div class="text-center">
                                            ©
                                            <script>
                                                document.write(new Date().getFullYear())
                                            </script>,
                                            dibuat dengan <i class="fa fa-heart" aria-hidden="true"></i> oleh
                                            <a href="https://www.creative-tim.com" class="font-weight-bold text-pink-500 hover:shadow-lg"
                                                target="_blank">{{ config('app.name') }}</a>
                                        </div>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--   Core JS Files   -->
        <script src="{{asset('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
        <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
        <script src="{{asset('assets/js/material-kit.min.js?v=3.0.4')}}" type="text/javascript"></script>
    </body>
    </html>
