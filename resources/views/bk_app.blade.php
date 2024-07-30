<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Vue Laravel SPA') }}</title>

        @vite('resources/css/app.css')
        @vite('resources/js/app.js') <!-- Vue 必須 -->

    </head>
    
    <body>
        <div id="app"></div>
    </body>

</html>
