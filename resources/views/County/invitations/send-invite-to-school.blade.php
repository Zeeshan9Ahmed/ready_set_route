@extends('County.slicing.master')
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

                  <form class="upload-pkg-form push-msg row" method="post" action="{{route('inviteSchool')}}">

                  @csrf
                     <div class=" col-12 form-group">
                        <input type="name" placeholder="School" name="name" required>
                     </div>
                     <div class=" col-12 form-group">
                     @if($errors->any())
                        <span style="color: #431500 ;" class="text-danger">{{$errors->first()}}</span>
                     @endif 
                        <input type="email" placeholder="Email" name="email" required>
                     </div>
                     <div class=" col-12 form-group">
                        <input type="tel" placeholder="Phone Number" name="phone" required>
                     </div>
                     
                     <div class=" col-12 form-group">
                        <input type="text" placeholder="Location" name="location" required>
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