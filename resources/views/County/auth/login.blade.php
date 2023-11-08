
@extends('dashboard.auth')

@section('contents')
   <section class="genWrap">
      <div class="loginBox">
         <div class="logoBox">
            <img src="assets/images/dash-logo.png" alt="">
         </div>
         <div class="textBox">
            <h1 class="heading">Login</h1>

             <p class="login-box-msg" style=" font-size: 22px; text-align: center;">
             @if($errors->any())
             <span style="color: #431500 ;" class="text-danger">{{$errors->first()}}</span>
            @endif  
                  
                </p>
            <form action="{{route('countyLogin')}}" method="post">
                 @csrf
               <div class="form-group type-1">
                  <input type="email"  placeholder="Email" name="email"
                            value="{{old('email')}}" style="background-color: #000 !important;">
               </div>
               <div class="form-group type-2 mb-3">
                  <input type="password" class="form-control" placeholder="Password" name="password">
                  <input type="hidden" name="device_token" id="device_token">

               </div>
               <a href="#!" class="forgotBtn">Forgot Password?</a>
               <div class="form-group">
                  <button class="loginBtn">Login</button>
               </div>
            </form>
         </div>
      </div>
   </section>

@endsection