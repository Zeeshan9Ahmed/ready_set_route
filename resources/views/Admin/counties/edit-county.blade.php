@extends('dashboard.master')
@section('contents')
<div class="gen-sec">

	<div class="container type-2">
		<div class="row">
             <div class="gentableWrap type-1 col-6">
                  <h1 class="heading"> Edit County </h1>

                  <form class="upload-pkg-form push-msg row" method="post" action="{{route('edit-county')}}">
                    @csrf
                    <input type="hidden" placeholder="State" name="county_id"  value="{{$county->id}}" required>

                     <div class=" col-12 form-group">
                     @error('county_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <input type="text" placeholder="State" name="county_name"  value="{{$county->county_name}}" required>
                     </div>
                     <div class="col-12 form-group mt-3">
                        <button class="sendBtn">Edit</button>
                     </div>
                  </form>
               </div>
            </div>
         
	</div>
</div>


@endsection


@section('additional-scripts')
<script>


</script>
@endsection
