<div class="dashboard-head-right">
            <div class="header-leftwrap">  
              <div class="leftInner">
              <a href="{{ route('countyDashboard') }}"><img src="{{asset('public/admin/assets/images/dash-logo.png')}}" class="img-fluid fixedLogo"></a>
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
                    <a class="indicator" href="{{ url('sub-admin-county/messages') }}" ><i class="far fa-comment-dots"></i></a>
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
                  <a class="indicator" href="{{ route('get-county-profile') }}">My Profile</a>
                  <a href="{{ route('county_admin_logout') }}">Logout</a>                      
                </div>
              </li>
            </ul>
          </div>