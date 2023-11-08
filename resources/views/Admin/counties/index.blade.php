@extends('dashboard.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-12">

               <h1 class="heading">Counties
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">County Name</th>
                        <th scope="col">County Email</th>
                        <th scope="col">No. of Schools</th>
                        <th scope="col">No. of Teachers</th>
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                        <th scope="col">No. of Drivers</th>
                        
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($counties as $county)
                     <tr>
                        
                        <td>{{$county->county_name}}</td>
                        <td>{{$county->email?$county->email:"----"}}</td>
                        <td>{{$county->total_schools}}</td>
                        <td>{{$county->teacher_count}}</td>
                        <td>{{$county->parent_count}}</td>
                        <td>{{$county->student_count}}</td>
                        <td>{{$county->driver_count}}</td>
                        
                        <td><a class="viewBtn" href="{{ route('admin-county-detail', $county->id)}}">View Details</a></td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
            {{--   
               
            <div class="col-12">
               <a class="genBtn type-3" href="invite-2.php">Invite</a>           
            </div>
               
               --}}
	</div>
</div>

@endsection