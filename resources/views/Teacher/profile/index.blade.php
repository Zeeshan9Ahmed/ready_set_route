@extends('Teacher.slicing.master')
@section('contents')

<div class="gen-sec">
   <div class="container type-2">
      <h5 class="black-head text-center">Welcome to Your Account</h5>
      @if($errors->any())
         
             <span style="color: #431500 ;" class="text-danger">error{{$errors->first()}}</span>
      @endif
      <div class="user-info-box">
         <div class="avatar-upload mb-3">
         <form method="post" enctype="multipart/form-data" action="{{ route('teacher_change_image') }}">
            @csrf
            <div class="avatar-edit">
               <input type="file" id="imageUpload" name="image" accept=".png, .jpg, .jpeg">
               <label for="imageUpload"><i class="fas fa-plus"></i></label>
            </div>
         </form>

            <div class="avatar-preview">
               <div id="imagePreview" style="background-image: url({{auth('teacher')->user()->image ? auth('teacher')->user()->image : asset('public/avatar.png') }});">
               </div>
            </div>

         </div>
         <div class="info-box">
            <div class="user-detail-box">
               <div class="details">
                  <label>User Name</label>
                  <p>{{ auth('teacher')->user()->name }}</p>
               </div>
               <div class="edit-btn">
                  <a href="javascript:void(0)" data-toggle="modal" data-target="#newUsername-modal">Edit</a>
               </div>
            </div>
            <div class="user-detail-box">
               <div class="details">
                  <label>Phone Number</label>
                  <p>{{ auth('teacher')->user()->phone }}</p>

               </div>
               <div class="edit-btn">
                  <a href="javascript:void(0)" data-toggle="modal" data-target="#newNumber-modal">Edit</a>
               </div>
            </div>
            <div class="user-detail-box">
               <div class="details">
                  <label>Email</label>
                  <p>{{ auth('teacher')->user()->email }}</p>

               </div>

            </div>
         </div>
         <div class="change-pass-wrap">
            <h5 class="black-head m-0">Password &amp; Authentication</h5>
            <div class="pass-btn-box">
               <a href="javascript:void(0)" class="black-btn" data-toggle="modal" data-target="#newPassword-modal">Change Password</a>
            </div>
         </div>
      </div>
   </div>
</div>


<!-- Change Phone Number Modal Start -->

<div class="modal payment-popup fade" id="newNumber-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <form method="post" action="{{route('teacher-admin-updateprofile')}}">
      @csrf
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-body">
               <div class="popup-head">
                  <h6>Chanege Your Number</h6>
                  <p><span>Enter a new Number.</span> </p>
                  <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="credit-card-info">

                  <input type="text" name="phone" maxlength="20" placeholder="Phone Number" value="{{ auth('teacher')->user()->phone }}" class="card-input" required>
                  <button type="submit" class="card-btn">Submit</button>

               </div>
            </div>
         </div>
      </div>
</div>
</form>


<!-- End -->


<!-- Change User Name Modal Start -->
<div class="modal payment-popup fade" id="newUsername-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <form method="post" action="{{route('teacher-admin-updateprofile')}}">
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

                  <input type="text" name="user_name" maxlength="20" placeholder="User Name" value="{{ auth('teacher')->user()->name }}" class="card-input">
                  <button type="submit" class="card-btn">Submit</button>

               </div>
            </div>
         </div>
      </div>
</div>
</form>
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
          <form method="POST" action="{{ route('teacher_admin_change_password') }}">
            @csrf
            <input type="password" name="new_password" minlength="8" maxlength="15" placeholder="New Password" class="card-input" required>
            <input type="password" name="confirm_password" minlength="8" maxlength="15" placeholder="Confirm Password" class="card-input" required>
            <button type="submit" class="card-btn">Submit</button>
          </form>
        </div>
      </div> 
    </div>
  </div>
</div>
@if($errors->any())
    <span style="color: #431500 ;" class="text-danger">{{$errors->first()}}</span>
@endif  
<!-- End -->

@endsection
@section('additional-scripts')
<script>
    {{--
        @if($errors->any())
        alert("{{$errors->first()}}")
    @endif    
        
        --}}
      
</script>
@endsection