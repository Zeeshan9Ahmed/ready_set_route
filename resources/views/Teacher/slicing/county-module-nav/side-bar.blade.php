<div class="mobile-wrap">  
       <aside>   
        <div class="side-logo">
         <a href="{{ route('teacherDashboard') }}"><img src="{{asset('public/admin/assets/images/dash-logo.png')}}" class="img-fluid"></a>
       </div>
       <div class="dashboard-links">
         <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

              <a class="nav-link" href="{{ route('teacherDashboard') }}" >Dashboard</a>
              <a class="nav-link" href="{{ route('teacher-admin-parents') }}" >Parents</a>
              <a class="nav-link" href="{{ route('teacher-admin-students') }}" >Students</a>
              <a class="nav-link" href="{{ route('teacher-admin-drivers') }}" >Drivers</a>
              @php 
                  $show_dot=auth('teacher')->user()->show_notification_red_dot;
                  $url = "sub-admin-teacher/delays";
                  $url = $show_dot==1?$url."/1":$url;
                  
                  
                  @endphp
              <a class="nav-link" href="{{ url($url) }}" >Delays</a>
              <a class="nav-link" href="{{ url('sub-admin-teacher/notifications') }}" >Notifications</a>
              {{--
                --}}
              <a class="nav-link" href="{{ url('sub-admin-teacher/messages') }}" >Messages</a>

      </div>