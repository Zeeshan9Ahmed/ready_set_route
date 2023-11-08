@extends('dashboard.master')
@section('contents')


<div class="gen-sec">
	<div class="container type-2">
		 <div class="gentableWrap type-1 col-12">
               <h1 class="heading">School
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">School Name</th>
                        <th scope="col">School Email</th>
                        <th scope="col">County Name</th>
                        <th scope="col">No. of Teachers</th>
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                        <th scope="col">No. of Drivers</th>
                       
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                  @foreach ($schools as $school)   
                  <tr>
                        
                        <td>{{ $school->school_name?$school->school_name : "---"}}</td>
                        <td>{{ $school?->email?$school->email : "---"}}</td>
                        <td>{{ $school->county_name}}</td>
                        <td>{{ $school->teacher_count}}</td>
                        <td>{{ $school->parent_count}}</td>
                        <td>{{ $school->student_count}}</td>
                        <td>{{ $school->driver_count}}</td>
                       
                        <td><a class="viewBtn" href="{{ route('admin-school-detail', $school->id ) }}">View Details</a></td>
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