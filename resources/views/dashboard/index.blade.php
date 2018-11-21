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
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-order-tab" data-toggle="pill" href="#v-pills-order" role="tab" >Order</a>
                        <a class="nav-link" id="v-pills-delivery-tab" data-toggle="pill" href="#v-pills-delivery" role="tab" >Delivery</a>
                        {{-- <a class="nav-link" id="v-pills-delivery-history-tab" data-toggle="pill" href="#v-pills-delivery-history" role="tab" aria-controls="v-pills-delivery-history" aria-selected="false">Delivery History</a>
                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a> --}}
                    </div>
                </div>
            
                <div class="col-md-7">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-baic-info-tab">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="order-tab" data-toggle="tab" href="#order-charts" role="tab">Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="expend-tab" data-toggle="tab" href="#expend-charts" role="tab">Expend</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="3-tab" data-toggle="tab" href="#b" role="tab" >3</a>
                                </li> --}}
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="order-charts" role="tabpanel" >
                                    <canvas id="order-total-chart" width="800" height="450"></canvas>
                                    <script>
                                        var date = new Date();
                                        const DAY = 1000 * 60 * 60 * 24;
                                        var weekly_x = []
                                        for (let i = 0; i < 7; i++) {
                                            var month = date.getUTCMonth() + 1; //months from 1-12
                                            var day = date.getUTCDate();

                                            newdate = month + "/" + day;
                                            weekly_x.unshift(newdate);
                                            date.setTime(date.getTime() - DAY);
                                        }
                                        new Chart(document.getElementById("order-total-chart"), {
                                            type: 'line',
                                            data: {
                                                labels: weekly_x,
                                                datasets: [{ 
                                                    data:  {{json_encode($weekly_order_count)}},
                                                    label: "orders",
                                                    borderColor: "#3e95cd",
                                                    fill: false
                                                }
                                                ]
                                            },
                                            options: {
                                                title: {
                                                display: true,
                                                text: 'Weekly Order Over Time'
                                                }
                                            }
                                            });
                                    </script>

                                    <br><br><br>
                                    <canvas id="store-percent-chart-order" width="800" height="450"></canvas>
                                    <script>
                                        new Chart(document.getElementById("store-percent-chart-order"), {
                                            type: 'pie',
                                            data: {
                                            labels: ["starbucks", "tim hortons", "waves coffe", "shop2", "shop1"],
                                            datasets: [{
                                                label: "order times:",
                                                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                                data: [2,3,10,4,7,0]
                                            }]
                                            },
                                            options: {
                                            title: {
                                                display: true,
                                                text: 'Weekly Store Proportion'
                                            }
                                            }
                                        });
                                    </script>
                                </div>

                                <div class="tab-pane fade" id="expend-charts" role="tabpanel" >
                                    <canvas id="total-spend-chart" width="800" height="450"></canvas>
                                    <script>
                                        new Chart(document.getElementById("total-spend-chart"), {
                                            type: 'line',
                                            data: {
                                                labels: weekly_x,
                                                datasets: [{ 
                                                    data: {{json_encode($weekly_order_spend)}},
                                                    label: "cost($)",
                                                    borderColor: "#3e95cd",
                                                    fill: false
                                                }
                                                ]
                                            },
                                            options: {
                                                title: {
                                                display: true,
                                                text: 'Weekly Spend'
                                                }
                                            }
                                            });
                                    </script>
                                    
                                    <canvas id="store-ranking-chart-spend" width="800" height="450"></canvas>
                                    <script>
                                        new Chart(document.getElementById("store-ranking-chart-spend"), {
                                            type: 'bar',
                                            data: {
                                            labels: ["starbucks", "tim hortons", "waves coffe", "shop2", "shop1"],
                                            datasets: [
                                                {
                                                label: "weekly spend($)",
                                                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                                data: [2.2,3.4,10.33,4.11,7.33,0]
                                                }
                                            ]
                                            },
                                            options: {
                                            legend: { display: false },
                                            title: {
                                                display: true,
                                                text: 'Store Spending'
                                            }
                                            }
                                        });
                                    </script>
                                </div>
                                {{-- <div class="tab-pane fade" id="b" role="tabpanel">
                                    ..3.
                                </div> --}}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-delivery" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="delivery-tab" data-toggle="tab" href="#delivery-charts" role="tab">Delivery</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="earn-tab" data-toggle="tab" href="#earn-charts" role="tab">Earn</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="3-tab" data-toggle="tab" href="#b" role="tab" >3</a>
                                </li> --}}
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="delivery-charts" role="tabpanel" >
                                    <canvas id="delivery-total-chart" width="800" height="450"></canvas>
                                    <script>
                                        new Chart(document.getElementById("delivery-total-chart"), {
                                            type: 'line',
                                            data: {
                                                labels: weekly_x,
                                                datasets: [{ 
                                                    data: [86,114,106,333,0,555,666],
                                                    label: "delivery",
                                                    borderColor: "#3e95cd",
                                                    fill: false
                                                }
                                                ]
                                            },
                                            options: {
                                                title: {
                                                display: true,
                                                text: 'Weekly Delivery Over Time'
                                                }
                                            }
                                            });
                                    </script>

                                    <br><br><br>
                                    <canvas id="store-percent-chart-delivery" width="800" height="450"></canvas>
                                    <script>
                                        new Chart(document.getElementById("store-percent-chart-delivery"), {
                                            type: 'pie',
                                            data: {
                                            labels: ["starbucks", "tim hortons", "waves coffe", "shop2", "shop1"],
                                            datasets: [{
                                                label: "delivery times:",
                                                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                                data: [2,3,10,4,7,0]
                                            }]
                                            },
                                            options: {
                                            title: {
                                                display: true,
                                                text: 'Weekly Store Proportion (Delivery)'
                                            }
                                            }
                                        });
                                    </script>
                                </div>

                                <div class="tab-pane fade" id="earn-charts" role="tabpanel" >
                                    <canvas id="total-earn-chart" width="800" height="450"></canvas>
                                    <script>
                                        new Chart(document.getElementById("total-earn-chart"), {
                                            type: 'line',
                                            data: {
                                                labels: weekly_x,
                                                datasets: [{ 
                                                    data: [13.45,4,0,3.33,7,3,19],
                                                    label: "earn($)",
                                                    borderColor: "#3e95cd",
                                                    fill: false
                                                }
                                                ]
                                            },
                                            options: {
                                                title: {
                                                display: true,
                                                text: 'Weekly Earn'
                                                }
                                            }
                                            });
                                    </script>
                                    
                                    <br><br><br>
                                    <canvas id="store-ranking-chart-earn" width="800" height="450"></canvas>
                                    <script>
                                        new Chart(document.getElementById("store-ranking-chart-earn"), {
                                            type: 'bar',
                                            data: {
                                            labels: ["starbucks", "tim hortons", "waves coffe", "shop2", "shop1"],
                                            datasets: [
                                                {
                                                label: "weekly earn($)",
                                                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                                                data: [2.2,3.4,10.33,4.11,7.33,0]
                                                }
                                            ]
                                            },
                                            options: {
                                            legend: { display: false },
                                            title: {
                                                display: true,
                                                text: 'Store Earn'
                                            }
                                            }
                                        });
                                    </script>
                                </div>
                                {{-- <div class="tab-pane fade" id="b" role="tabpanel">
                                    ..3.
                                </div> --}}
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="v-pills-delivery-history" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            safsfasdf
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <h2>asfdasf</h2>
                        </div> --}}
                    </div>
                </div>
            </div>
          </div>
        </main>
    </div>
</body>
</html>