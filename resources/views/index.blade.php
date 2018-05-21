<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Water Your Flippin Ferns!</title>

    </head>
    <body>
        <app id="app" v-bind:initial-plants="{{ $plants }}">    
        </app>
    <script src="js/app.js"></script>
    </body>
</html>
