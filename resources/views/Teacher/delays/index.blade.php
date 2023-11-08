@extends('Teacher.slicing.master')

@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		<div class="searchRow">
               
               <div class="gentableWrap type-1 col-12">
                  <h1 class="heading">Delays
                    
                  </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Driver Name</th>
                        <th scope="col">Bus Number</th>
                        <th scope="col">School Name</th>
                        <th scope="col">County Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Reasons</th>
                       
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($delays as $delay)
                     <tr>
                        
                        <td>{{$delay->driver_name}}</td>
                        <td>{{$delay->vehicle_number??"0000"}}</td>
                        <td>{{$delay->school_name}}</td>
                        <td>{{$delay->county_name}}</td>
                        <td>{{$delay->date}}</td>
                        <td>{{$delay->time}}</td>
                        <td>{{$delay->reason}}</td>
                       
                     </tr>
                     @endforeach
                    
                  </tbody>
               </table>
            </div>
	</div>
</div>


@endsection