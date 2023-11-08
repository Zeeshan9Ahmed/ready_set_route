@extends('Teacher.slicing.master')
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
                  <h1 class="heading">Child Detail
                     
                  </h1> 

                  <form class="upload-pkg-form push-msg row" method="post" action="{{ route('teacher-admin-add-child') }}">
                    @csrf
                    <input type="hidden" name="parent_id" placeholder="Child Name"  value="{{$parent_id}}" required>

                     <div class=" col-12 form-group">
                        <input type="name" name="name" placeholder="Child Name" required>
                     </div>
                     <div class=" col-12 form-group">
                     @if($errors->any())
                        <span style="color: #431500 ;" class="text-danger">{{$errors->first()}}</span>
                     @endif
                        <input type="email" name="email" placeholder="Email" required>
                     </div>
                     <div class=" col-12 form-group">
                        <input type="password" name="password" placeholder="Password" required>
                     </div>
                     
                     <div class=" col-12 form-group">
                        <input type="text" name="phone" placeholder="phone" required>
                     </div>

                     <div class="form-group type-2 mb-3">
                        <input type="text" name="address" id="autocomplete" class="form-control" placeholder="Select Location" required>
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                     </div>
                     <div class=" col-12 form-group">
                     
                     <select name="driver_id" id="driver_id" required>
                        <option value="">Choose A Driver</option>
                        @foreach( $drivers as $driver)
                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                        @endforeach
                        
                     </select>
                     </div>
                     <div class="col-12 form-group mt-3">
                        <button class="sendBtn">Submit</button>
                     </div>
                     
               
                  </form>

               </div>
            </div>
	</div>
</div>



@endsection

@section('additional-scripts')
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script>
google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
    var input = document.getElementById('autocomplete');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        $('#latitude').val(place.geometry['location'].lat());
        $('#longitude').val(place.geometry['location'].lng());
    });
}
</script>
@endsection