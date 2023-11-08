<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Ready Set Route</title>
  <link rel="icon" href="./assets/images/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('public/admin/assets/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('public/admin/assets/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('public/admin/assets/css/style.css')}}" />
  <link rel="stylesheet" href="{{asset('public/admin/assets/css/responsive.css')}}" />
</head>
<body>
  <div id="loading" class="d-flex justify-content-center align-items-center">
    <img src="{{asset('public/admin/assets/images/splash-logo.png')}}" alt="" class="zoom-in-zoom-out pulse">
  </div>
  <header>
    <div class="container-fluid">
      <div class="row">
        <div class="head-left-box"></div>      
         @include('dashboard.inc.header')
        </div>
      </div>
    </div>
    <a href="javascript:void(0)" class="mobile-toggle"><i class="fas fa-bars"></i></a>



    <!-- Button trigger modal -->


    <div class="offcanvas offcanvas-start p-0" tabindex="-1" id="sideNavs" aria-labelledby="sideNavsLabel">
    @include('dashboard.inc.aside')
    </div>
  </aside>
</div> 

  </header>



@section('contents')

<!-- Change User Name Modal Start -->
<div class="modal payment-popup fade" id="newUsername-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <form method="post" action="{{route('updateprofile')}}">
             @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="popup-head">
          <h6>Chanege Your User Name</h6>
          <p><span>Enter a new user name.</span> </p>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="credit-card-info">

            <input type="text" name="name" maxlength="20" placeholder="User Name" class="card-input">
            <button type="submit" class="card-btn">Submit</button>

        </div>
      </div> 
    </div>
  </div>
</div>
          </form>
<!-- End -->

<!-- Change Phone Number Modal Start -->
<div class="modal payment-popup fade" id="newNumber-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="popup-head">
          <h6>Chanege Your Phone Number</h6>
          <p><span>Enter a new number.</span> </p>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="credit-card-info">
          <form>
            <input type="tel" name="" maxlength="15" placeholder="New Phone Number" class="card-input">
            <button type="submit" class="card-btn">Submit</button>
          </form>
        </div>
      </div> 
    </div>
  </div>
</div>
<!-- End -->

<!-- Change Phone Number Modal Start -->
<div class="modal payment-popup fade" id="newEmail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="popup-head">
          <h6>Chanege Your Email</h6>
          <p><span>Enter a new email.</span> </p>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="credit-card-info">
          <form>
            <input type="tel" name="" maxlength="15" placeholder="Update Email" class="card-input">
            <button type="submit" class="card-btn">Submit</button>
          </form>
        </div>
      </div> 
    </div>
  </div>
</div>
<!-- End -->

<!-- Change Password Modal Start -->
<div class="modal payment-popup fade" id="newPassword-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="popup-head">
          <h6>Chanege Your Password</h6>
          <p><span>Enter a new password.</span> </p>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="credit-card-info">
          <form>
            <input type="password" name="" maxlength="30" placeholder="New Password" class="card-input">
            <input type="password" name="" maxlength="15" placeholder="Confirm Password" class="card-input">
            <button type="submit" class="card-btn">Submit</button>
          </form>
        </div>
      </div> 
    </div>
  </div>
</div>
<!-- End -->

<!-- Change Email Address Modal Start -->
<div class="modal payment-popup fade" id="newEmail-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="popup-head">
          <h6>Chanege Your Email Address</h6>
          <p><span>Enter a new email addressand your existing password.</span> </p>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="credit-card-info">
          <form>
            <input type="email" name="" maxlength="30" placeholder="New Email Address" class="card-input">
            <input type="email" name="" maxlength="30" placeholder="Confirm Email Address" class="card-input">
            <input type="password" name="" maxlength="30" placeholder="Current Password" class="card-input">
            <button type="submit" class="card-btn">Submit</button>
          </form>
        </div>
      </div> 
    </div>
  </div>
</div>
<!-- End -->

<!-- Assign Teacher Modal -->
<div class="modal fade genModal" id="assignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h1 class="heading">Assign teacher to another teacher</h1>
        <form>
          <div class="form-group">
            <select>
              <option disabled selected>Assign to</option>
              <option >ABCD</option>
              <option >ABCD</option>             
            </select>
          </div>
          <div class="form-group">
            <input type="text" name="" placeholder="Timing">
          </div>
          <div class="form-group">
            <input type="text" name="" placeholder="Reason">
          </div>
          <div class="form-group">
            <button class="genBtn">Done</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="{{asset('public/admin/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/admin/assets/js/bootstrap.min.js')}}"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{asset('public/admin/assets/js/custom.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  $(document).ready(function(){
  $("#imageUpload").change(function(){
    var bgImage = $('#imageUpload').css('background-image').replace(/^url|[\(\)]/g, '');

  alert(bgImage);

  $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{ route('change-profile-image') }}",
        data : {'data' : "abc"},
        type : 'POST',
        dataType : 'json',
        success : function(result){

            console.log("===== " + result + " =====");

        }
    });



  });
});
</script>
</body>

</html>

