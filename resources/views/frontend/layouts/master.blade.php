<!DOCTYPE html>
<html>
<head>
    <title>Multi-Step Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/frontend/css/form.css?v={{ time() }}">
    <link rel="stylesheet" href="/assets/frontend/css/review.css?v={{ time() }}">
</head>
<body>
<div class="container">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/assets/frontend/js/form.js"></script>
</body>
</html>
