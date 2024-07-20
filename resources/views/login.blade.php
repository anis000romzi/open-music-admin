<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>Login - MFT Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/18ba30db93.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container row text-center mx-auto vh-100">
        <div class="col-sm-12 my-auto">
            <h1 class="mb-4"><b>Admin - My Free Tunes</b></h1>
            @if (session('error'))
                <div class="alert alert-danger col-lg-5 col-sm-8 mx-auto">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('authenticate') }}" method="POST" class="col-lg-5 col-sm-8 mx-auto">
                @csrf
                <div class="form-floating col-auto mb-2">
                    <input type="username" value="{{ session('username') }}" id="username" name="username"
                        class="form-control" placeholder="Username" required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating col-auto mb-4">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required>
                    <label for="password">Password</label>
                </div>
                <div class="col-auto mb-2">
                    <button type="submit" class="btn btn-primary mb-3 col-lg-5 col-sm-8 mx-auto">Log In</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
