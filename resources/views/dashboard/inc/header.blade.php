   <div class="dashboard-head-right">
            <div class="header-leftwrap">  
              <div class="leftInner">
              <a href="{{ route('admin-dashboard') }}"><img src="{{asset('public/admin/assets/images/dash-logo.png')}}" class="img-fluid fixedLogo"></a>
                <a href="#!" class="sideToggle"></a> 
                <a class="btn sideToggle" data-bs-toggle="offcanvas" href="#sideNavs" role="button" aria-controls="sideNavs">
                  <i class="fas fa-bars"></i>
                </a>
                <h1 class="heading">Welcome {{ auth('admin')->user('admin')->name }}!</h1>  
              </div>  
              <div class="rightInner">        
             
              <div class="header-notificationwrap">
                <ul>
                <li class="list-inline-item notification-dropdown">
                  @php 
                  $show_dot=auth('admin')->user('admin')->show_notification_red_dot;
                  $url = "admin/reports/delays";
                  $url = $show_dot==1?$url."/1":$url;
                  
                  
                  @endphp
                    <a class="indicator" href="{{ url($url) }}" ><i class="far fa-bell {{ $show_dot?'bellicn':'' }}"></i></a>                
                  </li> 
                  <li class="list-inline-item notification-dropdown">
                    <a class="indicator" href="{{ url('admin/messages') }}" ><i class="far fa-comment-dots"></i></a>
                  </li>
                </ul>
              </div>
              </div> 
            </div>
            <div class="head-right-box">
             <ul>
               <!-- <li><a href="javascript:void(0)"><i class="far fa-bell"></i></a></li> -->
               <li class="user-dropdown">
                <p class="name">{{ auth('admin')->user('admin')->name }}</p>
                <p class="number">{{ auth('admin')->user('admin')->phone }}</p>
              </li>
              <li class="head-image">
                <img src="{{auth('admin')->user()->image ? auth('admin')->user()->image : asset('public/avatar.png') }}" class="img-fluid">

                <div class="editDropdown">
                  <a class="indicator" href="{{ route('profile') }}">My Profile</a>
                  <a href="{{ route('admin_logout') }}">Logout</a>                      
                </div>
              </li>
            </ul>
          </div>