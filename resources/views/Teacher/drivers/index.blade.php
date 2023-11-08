@extends('Teacher.slicing.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
<div class="gentableWrap type-1 col-12">
               <h1 class="heading">Drivers
                 
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Driver Name</th>                         
                        <th scope="col">Driver Email</th>                         
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                       <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ( $drivers as $driver)
                     <tr>
                        
                        <td>{{$driver->driver_name}}</td>
                        <td>{{$driver->email}}</td>
                        <td>{{$driver->total_parents}}</td>
                        <td>{{$driver->total_students}}</td>
                     
                        <td><a class="viewBtn" href="{{ route('teacher-admin-driver-detail', $driver->id) }}">View Details</a></td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
       </div>
</div>

@endsection