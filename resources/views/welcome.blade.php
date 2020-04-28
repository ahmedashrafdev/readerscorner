<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
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

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
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

            <div class="content">
                <div class="title m-b-md">
                    <iframe style="width:100vw; height:100vh" src="https://accept.paymobsolutions.com/api/acceptance/iframes/7557?payment_token=ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SmxlSEFpT2pFMU9EZ3dOVGswTlRVc0ltTjFjbkpsYm1ONUlqb2lSVWRRSWl3aVlXMXZkVzUwWDJObGJuUnpJam96TXpBc0ltOXlaR1Z5WDJsa0lqbzBPVE01TlRVMUxDSnBiblJsWjNKaGRHbHZibDlwWkNJNk5EVTVNU3dpYkc5amExOXZjbVJsY2w5M2FHVnVYM0JoYVdRaU9tWmhiSE5sTENKaWFXeHNhVzVuWDJSaGRHRWlPbnNpWm1seWMzUmZibUZ0WlNJNkltRm9iV1ZrSWl3aWJHRnpkRjl1WVcxbElqb2lZV2h0WldRaUxDSnpkSEpsWlhRaU9pSnpkSEpsWlhRaUxDSmlkV2xzWkdsdVp5STZJakV3SWl3aVpteHZiM0lpT2lKbWJHOXZjaUlzSW1Gd1lYSjBiV1Z1ZENJNklqRXlJaXdpWTJsMGVTSTZJbU5oYVhKdklpd2ljM1JoZEdVaU9pSk9RU0lzSW1OdmRXNTBjbmtpT2lKRlIxQWlMQ0psYldGcGJDSTZJbUZvYldWa1FHRm9iV1ZrTG1OdmJTSXNJbkJvYjI1bFgyNTFiV0psY2lJNklqQXhNREl3TVRBaUxDSndiM04wWVd4ZlkyOWtaU0k2SWpFeU1qRWlMQ0psZUhSeVlWOWtaWE5qY21sd2RHbHZiaUk2SWs1QkluMHNJbkJ0YTE5cGNDSTZJakV3TlM0eE9USXVNVGN3TGpJNElpd2lkWE5sY2w5cFpDSTZNek0yTW4wLmZac1psYmJxd0F0TVc0cVQ4UFVpMHFzcW9yeDFTTEZoZklDSnpIZFVrQzVjWnlnQ3JaVmwwY2UxYlVOalZlbk44ZGp4bVdFU1l6ZlFKQnhPSzZVU0VB" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </body>
</html>
