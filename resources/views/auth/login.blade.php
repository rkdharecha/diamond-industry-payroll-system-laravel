<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <meta name="description" content="Smarthr - Bootstrap Admin Template">
      <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
      <meta name="author" content="Dreamguys - Bootstrap Admin Template">
      <meta name="robots" content="noindex, nofollow">
      <title>Login</title>
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/user.jpg') }}">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
      <!-- Fontawesome CSS -->
      <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
      <!-- Main CSS -->
      <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   </head>
   <body class="account-page">
      <!-- Main Wrapper -->
      <div class="main-wrapper">
         <div class="account-content">
            <div class="container">
               <div class="account-box">
                  <div class="account-wrapper">
                     <h3 class="account-title">Login</h3>
                     <p class="account-subtitle"></p>
                     <!-- Account Form -->
                     <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                           <label>Email Address</label>
                           <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                           @error('email')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col">
                                 <label>Password</label>
                              </div>
                              <div class="col-auto">
                                 <a class="text-sm" href="forgot-password.html" style="color:#ba3b62;">
                                 Forgot password ?
                                 </a>
                              </div>
                           </div>
                           <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                           <label class="form-check-label text-sm" for="remember" style="color:#ba3b62;">
                           {{ __('Remember Me') }}
                           </label>
                        </div>
                        <div class="form-group text-center">
                           <button class="btn btn-primary account-btn" type="submit">Login</button>
                        </div>
                        <div class="account-footer">
                           {{-- 
                           <p>Don't have an account yet? <a href="register.html">Register</a></p>
                           --}}
                        </div>
                     </form>
                     <!-- /Account Form -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /Main Wrapper -->
      <!-- jQuery -->
      <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
      <!-- Bootstrap Core JS -->
      <script src="{{ asset('assets/js/popper.min.js') }}"></script>
      <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
      <!-- Custom JS -->
      <script src="{{ asset('assets/js/app.js') }}"></script>
   </body>
</html>