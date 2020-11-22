<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SUSL</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Vidaloka&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="{{asset('/css/app.css')}}">
        <!-- Styles -->

        <style>
            html, body {

                color: #636b6f;
                font-family: 'Vidaloka', serif;
                font-weight: 200;

                margin: 0;
                background:url('https://images.pexels.com/photos/1851415/pexels-photo-1851415.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center;
            }
            .main-nav{
                max-height:50px;
                font-size:20px;





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
                position: fixed;
                right: 10px;
                top: 18px;

            }
            a{
                text-decoration:none;
                padding-right:10px;
                color:black;
            }


            .main-body{




            }
            .footer {
             position: fixed;
             left: 0;

                bottom: 0;
                width: 100%;
                max-height:100px;


                color: white;
                text-align: center;
            }
            a:hover{
                transform: scale(1.3);
            }




        </style>
    </head>
    <body>
    <div class="main-nav">
        <div class="flex-center position-fixed full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>


        </div>
        <div class="main-body">
        <div class="d-flex justify-content-center " style="margin-top:250px">

       <div class="p-2">
        <img src="storage/default/logo/SUSLv1.png" width=150px height=200px alt="" ></div>
        <div class="p-2 align-self-center">
        <h1 style="color:black;font-size:400% " >Welcome Sabra Social Media</h1>
        </div>

        </div>
        </div>
        <div class="footer">
        <hr>
        <ul class="nav justify-content-center">
            <li class="nav-item">
             <a class="nav-link" href="#">Sabaragamuwa University Of Srilanka </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
            </li>
            <li class="nav-item">
             <a class="nav-link" href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
             </li>
            <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa fa-github-square" aria-hidden="true"></i></a>
             </li>
            </ul>
            <hr>
        </div>

    </body>
</html>
