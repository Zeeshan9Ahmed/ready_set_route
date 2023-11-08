@extends('School.slicing.master')
@section('contents')


<div class="gen-sec">
	<div class="container type-2">
		<div class="row">

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

               <div class="gentableWrap type-1 col-8">
                  <h1 class="heading">Invite
                    
                  </h1> 

                  <form class="upload-pkg-form push-msg row" method="post" action="{{ route('inviteTeacher') }}">
                    @csrf
                     <div class=" col-12 form-group">
                        <input type="name" name="teacher_name" placeholder="Teacher Name" required>
                     </div>
                     <div class=" col-12 form-group">
                     @if($errors->any())
                        <span style="color: #431500 ;" class="text-danger">{{$errors->first()}}</span>
                     @endif
                        <input type="email" name="email" placeholder="Email" required>
                     </div>
                     <div class=" col-12 form-group">
                        <input type="tel" name="phone_number" placeholder="Phone Number" required>
                     </div>
                     
                     <div class=" col-12 form-group">
                        <input type="text" name="location" placeholder="Location" required>
                     </div>
                     <div class="col-12 form-group mt-3">
                        <button class="sendBtn">Send Invitation</button>
                     </div>
                     
               
                  </form>

               </div>
            </div>
	</div>
</div>



@endsection