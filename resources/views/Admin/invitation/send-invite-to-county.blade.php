@extends('dashboard.master')

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

                  <form class="upload-pkg-form push-msg row" method="post" action="{{route('inviteCounty')}}">
                    @csrf
                     <div class=" col-12 form-group">
                        <input type="name" placeholder="Name" name="county" required>
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
                     <div class="form-group type-2 mb-3">
                     <select id="state" name="state" required>
                        <option value="" disabled selected>Select State</option>
                         @foreach ($states as  $key => $state)
                        <option value="{{$state->id}}">{{  $state->state_name }}</option>
                        @endforeach
                     </select>
                     </div>
                     <div class="form-group type-2 mb-3">
                        <select id="county" name="county_id" required>
                           <option value="" disabled selected>Select County</option>
                        </select>
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


@section('additional-scripts')
<script>
  $(document).ready(function(){
    $('#state').on('change', function (e) {
        
        var state_id = this.value;
        $.ajax({
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // },
        url : "{{ route('state-counties') }}",
        data : {state_id : state_id},
        type : 'GET',
        dataType : 'json',
        success : function(result){
            let length =result.length
            $('select[name="county_id"]').empty();
            if ( length > 0 )
            {
               $.each(result, (key,value) => {
                  // console.log(key)
                  let num = ++key;
                  $('select[name="county_id"]').append('<option value="'+ value.id +'">'+  num +'  --  '+  value.county_name +'</option>');
               })

            }else
            {
               $('select[name="county_id"]').append('<option value="">No County Found</option>');
            }
           
        }
    });


    });
  

  });

</script>
@endsection