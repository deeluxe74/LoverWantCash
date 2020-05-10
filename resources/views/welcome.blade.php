<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- PWA SYSTEM -->
        <link rel="icon" type="image/png" sizes="512x512" href="512x512.png">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
            <!-- For IOS -->
            <!-- ICONE -->
            <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad.png">
            <link rel="apple-touch-icon" sizes="180x180" href="touch-icon-iphone-retina.png">
            <link rel="apple-touch-icon" sizes="167x167" href="touch-icon-ipad-retina.png">
            <!-- SplashScreen -->
            <meta name="apple-mobile-web-app-capable" content="yes" />
            <link href="apple_splash_2048.png" sizes="2048x2732" rel="apple-touch-startup-image" />
            <link href="apple_splash_1668.png" sizes="1668x2224" rel="apple-touch-startup-image" />
            <link href="apple_splash_1536.png" sizes="1536x2048" rel="apple-touch-startup-image" />
            <link href="apple_splash_1125.png" sizes="1125x2436" rel="apple-touch-startup-image" />
            <link href="apple_splash_1242.png" sizes="1242x2208" rel="apple-touch-startup-image" />
            <link href="apple_splash_750.png" sizes="750x1334" rel="apple-touch-startup-image" />
            <link href="apple_splash_640.png" sizes="640x1136" rel="apple-touch-startup-image" />

            <!-- Stylesheet -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
        <title>LoverWantCash</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Mali:200,300,400,500,600,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Spartan:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <index></index>
        </div>
    </body>

    <script>
        if('serviceWorker' in navigator){
            window.addEventListener('load', function(){
                navigator.serviceWorker.register('./service-worker.js').then(function(){
                    console.log('Service worker load');
                })
            })
        }

        // IOS DETECTION
        window.localStorage.setItem('isIos', false);
        // Detects if device is on iOS 
        const isIos = () => {
        const userAgent = window.navigator.userAgent.toLowerCase();
            return /iphone|ipad|ipod/.test( userAgent );
            }
        // Detects if device is in standalone mode
        const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);

        // Checks if should display install popup notification:
        if (isIos() && !isInStandaloneMode()) {
            window.localStorage.setItem('isIos', true);
        }
    </script>
</html>
