<div class="page-header">
  <div class="header-wrapper row m-0">
    <div class="header-logo-wrapper col-auto p-0">
      <div class="logo-wrapper" style="font-size: 23px"><a href="{{route('/')}}"><img src="{{asset('assets/images/favicon.png')}}">ISSET</a></div>
      <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
    </div>
    
    <div class="left-header col horizontal-wrapper ps-0">
      
    </div>
    
    <div class="nav-right col-8 pull-right right-header p-0">
      
      <ul class="nav-menus">
        
        <div> <a href="{{route('notifications')}}"><i class="fa fa-bell fa-2x"></i></a> </div>

        <li class="profile-nav onhover-dropdown p-0 me-0">
          
          <div class="media profile-media">
            
            
            <img class="b-r-10" src="{{asset('assets/images/dashboard/profile.jpg')}}" alt="">
            <div class="media-body">
              <span>{{Auth::user()->name}}</span>
              <p class="mb-0 font-roboto">{{Auth::user()->role}} <i class="middle fa fa-angle-down"></i></p>
            </div>
          </div>
          <ul class="profile-dropdown onhover-show-div">
            @guest
              <li><a href="{{url('/login')}}"><i data-feather="log-in"> </i><span>Se connecter</span></a></li>
            @else
              <li><a href="{{route('compte')}}"><span>Mon compte</span></a></li>
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                 <span>Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            @endguest

          </ul>
        </li>
      </ul>
    </div>
    <script class="result-template" type="text/x-handlebars-template">
      <div class="ProfileCard u-cf">
        <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
        <div class="ProfileCard-details">
          <div class="ProfileCard-realName">@{{name}}</div>
        </div>
      </div>
    </script>
    <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
  </div>
</div>
