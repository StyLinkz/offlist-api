<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Erfolg verifizieren</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-size: 16px;
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

            .content {
                text-align: center;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <p>
                    <strong>Your account has been verified successfully!</strong>
                    <br />
                    <span>You can close this window.</span>
                </p>
            </div>
        </div>
        <script>
            // (function () {
            //     document.addEventListener('DOMContentLoaded', function (e) {
            //         setTimeout(function (e) {
            //             window.location.replace('poc://offlist.de');
            //         }, 2000);
            //     });
            // })();
        </script>
    </body>
</html>
