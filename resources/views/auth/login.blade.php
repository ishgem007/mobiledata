<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

  <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Honourworld') }}</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('vendor/sb-admin-2.min.css') }}" rel="stylesheet">
  <style>
    body {
      background-image: url("{{ asset('bg1.jpg') }}") !important;
    }
    @media only screen and (min-width: 600px) {
      .login-changes {
        width: 500px;
        margin-left: auto;
        margin-right: auto;
      }
    }
    .input-group-append span {
      border-top-right-radius: 10rem;
      border-bottom-right-radius: 10rem;
      cursor: pointer;
    }
  </style>

</head>

<body class="bg-gradient-primary">

  <div style="margin:20px">
    <h2>
      <a href="/" style="color:#fff;"> Mobile Data</a>
    </h2>
  </div>
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5 login-changes">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form method="POST" action="{{ route('login') }}" class="user">
                    @csrf

                    <div class="form-group">
                      <input type="email" class="form-control form-control-user  @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter Email Address ...">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group input-group">
                      <input type="password" class="form-control form-control-user  @error('password') is-invalid @enderror" id="password" placeholder="Password" name="password" required autocomplete="current-password">
                      <div class="input-group-append" onclick="Toggle('password')">
                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-eye"></i></span>
                      </div>

                      @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      {{-- <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Remember Me</label>
                      </div> --}}
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                    
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

</div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
  <script>
    // Change the type of input to password or text 
        function Toggle(item) { 
            var temp = document.getElementById(item); 
            if (temp.type === "password") { 
                temp.type = "text"; 
            } 
            else { 
                temp.type = "password"; 
            } 
        } 
  </script>

</body>

</html>