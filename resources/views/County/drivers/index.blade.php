@extends('County.slicing.master')
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
                        <th scope="col">School Name</th>                           
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                        
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($drivers as $driver)
                     <tr>
                        
                        <td>{{$driver->driver_name}}</td>
                        <td>{{$driver->email}}</td>
                        <td>{{$driver->school_name}}</td>
                        <td>{{$driver->parent_count}}</td>
                        <td>{{$driver->student_count}}</td>
                       
                        <td><a class="viewBtn" href="{{ route('county-admin-driver-detail',[$driver->id, $driver->school_id])}}">View Details</a></td>
                     </tr>
                    @endforeach
                  </tbody>
               </table>
            </div>
           {{-- 
            <div class="col-12">
               <a class="genBtn type-3" href="invite-1.php" >Invite</a>           
            </div>
            --}}
	</div>
</div>

@endsection