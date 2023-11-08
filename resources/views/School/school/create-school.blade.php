<?php
// dd($states);
?>
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
  
  



@section('contents')




<section class="genWrap">
   <div class="loginBox">
      <div class="textBox">
         <h1 class="heading">School Information</h1>
         <form class="registrationForm" method="POST" enctype="multipart/form-data" action="{{route('save-school')}}">
            @csrf
            <div class="form-group type-2 mb-3">
               <input type="text" placeholder="School Name" name="school_name" required>
            </div>
            <input type="hidden" name="school_id" value="{{$school_id}}"/>
            <div class="form-group type-2 mb-3">
               <input type="text" placeholder="Phone" name="phone" required>
            </div>

            <div class="form-group type-2 mb-3">
               <input type="text" name="address" id="autocomplete" class="form-control" placeholder="Select Location">
			    <input type="hidden" name="latitude" id="latitude">
				<input type="hidden" name="longitude" id="longitude">
            </div>

            <div class="form-group type-2 mb-3">
               <input type="text" placeholder="Description" name="description" required>
            </div>
            <div class="form-group type-2 mb-3">
               <input type="file" placeholder="Upload Image" name="image">
            </div>
            
            <div class="form-group">
               <button class="loginBtn mt-4">Register</button>
            </div>
         </form>
      </div>
   </div>
   <style>
      .loginBox .textBox .form-group select {
       width: 100%;
       height: 60px;
       background: #431500ad;
       border-radius: 30px;
       overflow: hidden;
       border: 2px solid #431500;
       outline: none;
       font-size: 16px;
       color: #ffff;
       line-height: 1;
       padding-left: 25px;
    }  
    .loginBox .textBox .form-group.type-1::after, 
    .loginBox .textBox .form-group.type-2::after {
     content: none;
    }
   .loginBox .textBox .form-group input {
     padding-left: 25px;
  }
 </style>
</section>


<script src="{{asset('public/admin/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/admin/assets/js/bootstrap.min.js')}}"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{asset('public/admin/assets/js/custom.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
</body>

</html>

