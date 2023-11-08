<div class="mobile-wrap">  
       <aside>   
        <div class="side-logo">
         <a href="{{ route('countyDashboard') }}"><img src="{{asset('public/admin/assets/images/dash-logo.png')}}" class="img-fluid"></a>
       </div>
       <div class="dashboard-links">
         <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

         <a class="nav-link" href="{{ route('countyDashboard') }}" >Dashboard</a>
          <a class="nav-link" href="{{ route('county-admin-schools') }}" >Schools</a>
          <a class="nav-link" href="{{ route('county-admin-teachers') }}" >Teachers</a>
          <a class="nav-link" href="{{ route('county-admin-parents') }}" >Parents</a>
          <a class="nav-link" href="{{ route('county-admin-students') }}" >Students</a>
          <a class="nav-link" href="{{ route('county-admin-drivers') }}" >Drivers</a>
          <a class="nav-link" href="{{ url('sub-admin-county/notifications') }}" >Notifications</a>
          {{--
            <a class="nav-link" href="{{ url('sub-admin-county/subscription') }}" >Subscriptions</a>
            --}}
          <a class="nav-link" href="{{ url('sub-admin-county/messages') }}" >Messages</a>

      </div>