<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>JheckDoc</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {!!JheckDoc::installStyles()!!}
    </head>
    <body>
        <div id="app"></div>
        {!!JheckDoc::installScripts()!!}
    </body>
</html>
