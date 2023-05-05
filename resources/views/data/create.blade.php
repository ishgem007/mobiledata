<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

  <title>Mobile Data</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href= "{{ asset('vendor/sb-admin-2.min.css') }}" rel="stylesheet">
  <style>
    .form-box {
        max-width: 500px;
        margin: auto;
      }
      .footer-button {
        width: 100%;
        background: #4e73df;
        color: #fff;
        padding: 5px;
        border-radius: 4px;
        border: none;
      }
    .number::-webkit-inner-spin-button, 
    .number::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
  @media only screen and (max-width: 600px) {
        .sticky {
          position: fixed;
          top: 0;
          width: 100%;
          z-index: 2;
        }
        .sticky + .container-fluid {
          padding-top: 80px;
        }
        .sticky + .container {
          padding-top: 80px;
        }
        td {
          white-space: nowrap;
        }
        .notice-mobile {
          margin-top: 80px;
        }
      }
  </style>
  
  @yield('css')

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light sticky bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          {{-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button> --}}
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow mx-1"> <!-- Logout button -->
              <a href="{{ route('logout') }}" class="nav-link" 
                onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off"></i>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#">
              {{-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucfirst(auth()->user()->name) }}</span> --}}
              </a>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mobile Data</h1>
          </div>
          <div class="form-box">
            <form action="{{ route('data.send') }}" method="post">
              @csrf
              <div class="form-group">
                <div class="form-group">
                  <label for="month">Select a month</label>
                  <input type="month" name="month" id="month" class="form-control"
                  @error('month')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                </div>
                
              </div>
              <button type="submit" class="btn btn-primary mb-2 footer-button">Get Data</button>
            </form>
          </div>
        </div>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('vendor/sb-admin-2.min.js') }}"></script>

  @yield('javascript')

</body>

</html>





