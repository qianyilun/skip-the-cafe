<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Skip The Cafe') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .slogan {
            color: #636b6f;
            padding: 0 0 0 150px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .question {
            color: #636b6f;
            padding: 10px 50px;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Home
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="container">
                {{$user}}
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-baisc-info-tab" data-toggle="pill" href="#v-pills-basic-info" role="tab" aria-controls="v-pills-basic-info" aria-selected="true">Basic Info</a>
                        <a class="nav-link" id="v-pills-order-history-tab" data-toggle="pill" href="#v-pills-order-history" role="tab" aria-controls="v-pills-order-history" aria-selected="false">Order History</a>
                        <a class="nav-link" id="v-pills-delivery-history-tab" data-toggle="pill" href="#v-pills-delivery-history" role="tab" aria-controls="v-pills-delivery-history" aria-selected="false">Delivery History</a>
                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
                    </div>
                </div>
            
                <div class="col-md-7">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-basic-info" role="tabpanel" aria-labelledby="v-pills-baic-info-tab">
                            <canvas id="line-chart" width="800" height="450"></canvas>
                            <script>
                                new Chart(document.getElementById("line-chart"), {
                                    type: 'line',
                                    data: {
                                        labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
                                        datasets: [{ 
                                            data: [86,114,106,106,107,111,133,221,783,2478],
                                            label: "Africa",
                                            borderColor: "#3e95cd",
                                            fill: false
                                        }, { 
                                            data: [282,350,411,502,635,809,947,1402,3700,5267],
                                            label: "Asia",
                                            borderColor: "#8e5ea2",
                                            fill: false
                                        }, { 
                                            data: [168,170,178,190,203,276,408,547,675,734],
                                            label: "Europe",
                                            borderColor: "#3cba9f",
                                            fill: false
                                        }, { 
                                            data: [40,20,10,16,24,38,74,167,508,784],
                                            label: "Latin America",
                                            borderColor: "#e8c3b9",
                                            fill: false
                                        }, { 
                                            data: [6,3,2,2,7,26,82,172,312,433],
                                            label: "North America",
                                            borderColor: "#c45850",
                                            fill: false
                                        }
                                        ]
                                    },
                                    options: {
                                        title: {
                                        display: true,
                                        text: 'Order'
                                        }
                                    }
                                    });
                            </script>
                        </div>
                        <div class="tab-pane fade" id="v-pills-order-history" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <canvas id="pie-chart" width="800" height="450"></canvas>
                                <script>
                                new Chart(document.getElementById("pie-chart"), {
                        type: 'pie',
                        data: {
                          labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                          datasets: [{
                            label: "Population (millions)",
                            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                            data: [2478,5267,734,784,433]
                          }]
                        },
                        options: {
                          title: {
                            display: true,
                            text: 'Predicted world population (millions) in 2050'
                          }
                        }
                    });</script>
                        </div>
                        <div class="tab-pane fade" id="v-pills-delivery-history" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            safsfasdf
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <h2>asfdasf</h2>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </main>
    </div>
</body>
</html>