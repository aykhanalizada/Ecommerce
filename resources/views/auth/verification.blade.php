<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center align-items-center h-100">
            <div class="card-wrapper">
                <div class="brand">
                    <img src="images/logo.jpg" alt="bootstrap 4 login page">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Verify your email address</h4>
                        <form method="POST" action="{{route('verify')}}" class="my-login-validation" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="verification">We sent verification code to your email.
                                    Please check your inbox and enter the code below </label>
                                <div class="form-text text-muted text-center mb-2">
                                    6-digits code
                                </div>
                                <input id="verification" type="text" class="form-control" name="verification_code" required
                                       autofocus data-eye placeholder="Enter 6-digits code">
                                <div class="invalid-feedback">
                                    Password is required
                                </div>

                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger " style="font-size:14px;" role="alert">
                                    <div>
                                        <span class="fw-bold">Ensure that these requirements are met:</span>
                                        <ul class="mt-2 mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Verify Code
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; 2024 &mdash; Your Company
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
{{--<script src="js/login.js"></script>--}}
</body>
</html>
