<div class="header">
   <div class="header-left">
      <a href="{{ route('home') }}" class="logo">
      <img src="{{ asset('assets/img/favicon.jpg') }}" class="avatar" width="40" height="40" alt="">
      </a>
   </div>
   <a id="toggle_btn" href="javascript:void(0);">
   <span class="bar-icon">
   <span></span>
   <span></span>
   <span></span>
   </span>
   </a>
   <div class="page-title-box">
   </div>
   <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
   <ul class="nav user-menu">
      <li class="nav-item dropdown has-arrow main-drop">
         <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
         <span class="user-img"><img src="{{ asset('assets/img/favicon.jpg') }}" alt="">
               <span class="status online"></span></span>
         <span>{{ auth()->user()->name }}</span>
         </a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" style="display:none;" action="{{ route('logout') }}" method="POST">
               @csrf
            </form>
         </div>
      </li>
   </ul>
   <div class="dropdown mobile-user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
      <div class="dropdown-menu dropdown-menu-right">
         <a class="dropdown-item" href="login.html">Logout</a>
      </div>
   </div>
</div>

<div class="loader" style="background: url('{{ asset('assets/img/loader/loading.gif') }}') 
50% 50% no-repeat transparent;"></div>