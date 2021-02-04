<!doctype html>
<html>
    <head>
    <base href="/" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', "Laravel") }}</title>
        </head>
    <body>
       <div id="app">
            <app></app>
       </div>
       <script src="/public/js/app.js"></script>
       <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
       <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    </body>
</html>
