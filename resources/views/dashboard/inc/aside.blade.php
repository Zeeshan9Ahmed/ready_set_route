  <div class="mobile-wrap">  
       <aside>   
        <div class="side-logo">
         <a href="{{ route('admin-dashboard') }}"><img src="{{asset('public/admin/assets/images/dash-logo.png')}}" class="img-fluid"></a>
       </div>
       <div class="dashboard-links">
         <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

          <a class="nav-link" href="{{ route('admin-dashboard') }}" >Dashboard</a>
          <a class="nav-link" href="{{ route('admin-states') }}" >States</a>
          <a class="nav-link" href="{{ route('admin-counties') }}" >Counties</a>
          <a class="nav-link" href="{{ route('admin-schools') }}" >Schools</a>
          <a class="nav-link" href="{{ route('admin-teachers') }}" >Teachers</a>
          <a class="nav-link" href="{{ route('admin-parents') }}" >Parents</a>
          <a class="nav-link" href="{{ route('admin-students') }}" >Students</a>
          <a class="nav-link" href="{{ route('admin-drivers') }}" >Drivers</a>
          {{--
            <a class="nav-link" href="{{ url('admin/requests') }}" >Requests</a>
            --}}
            <a class="nav-link" href="{{ url('admin/messages') }}" >Messages</a>
            <a class="nav-link" href="{{ url('admin/subscription') }}" >Subscriptions</a>
            <a class="nav-link" href="{{ url('admin/notifications') }}" >Notifications</a>
            
            <a class="nav-link" href="{{ route('admin-state-management') }}" >State Management</a>
         
          <div class="dropdownWrap">   
           <a class="nav-link" id="dropdownNav">Reports <span><i class="ms-2 fas fa-chevron-down"></i></span></a>
           
           <ul class="nav nav-pills mb-3 dropdownList-2" id="pills-tab" role="tablist" style="display: none;">+
            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/reports/schools') }}" >Schools</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/reports/buses') }}" >Buses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/reports/attendance') }}" >Attendance</a>
            </li>
            <li class="nav-item">
                  @php 
                  $show_dot=auth('admin')->user('admin')->show_notification_red_dot;
                  $url = "admin/reports/delays";
                  $url = $show_dot==1?$url."/1":$url;
                  @endphp
              <a class="nav-link" href="{{ url($url) }}" >Delays</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/reports/financial') }}" >Financial</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('admin/reports/travel') }}" >Travel</a>
            </li>
          </ul>
        </div>
      </div>