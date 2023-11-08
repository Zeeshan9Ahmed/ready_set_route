@extends('School.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-12">
               <h1 class="heading">Drivers
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Date </th>
                        <th scope="col">Total Distance </th>
                        <th scope="col">Distance Unit</th>
                        <th scope="col">Fuel Price</th>
                        <th scope="col">Total Price</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($driver_distances as $distance)
                     <tr>
                        <td>{{\Carbon\Carbon::parse($distance->created_at)->isoFormat('MMMM Do YYYY')}}</td>
                        <td>{{$distance->total_distance}}</td>
                        <td>{{$distance->distance_type}}</td>
                        <td>{{$distance->fuel_price}} </td>
                        <td>{{$distance->total_price}} </td>
                     </tr>
                    @endforeach
                     
                  </tbody>
               </table>
            </div>
            
              
	</div>
</div>

@endsection