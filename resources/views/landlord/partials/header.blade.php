<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
@vite('resources/js/app.js')
    <link rel="icon" href="{{ asset('images/Logo/logo.png') }}" class="rounded" type="image/png">

    <meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Your custom CSS -->
<link href="{{ asset('css/landingpage/landingpage.css') }}" rel="stylesheet">
<link href="{{ asset('css/navigationstyle/landingandacccountprocessnavigation.css') }}" rel="stylesheet">


</head>

<body>
