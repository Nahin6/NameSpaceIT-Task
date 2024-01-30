<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @if (request()->has('message'))
        <div class="alert alert-danger">
            {{ request()->input('message') }}
        </div>
    @endif

    {{-- @if (isset($_GET['message']))
    <div class="alert alert-danger">
        {{ $_GET['message'] }}
    </div>
@endif --}}
@if (session('error_message'))
    <div class="error-message">
        {{ session('error_message') }}
    </div>
@endif



</body>



</html>
