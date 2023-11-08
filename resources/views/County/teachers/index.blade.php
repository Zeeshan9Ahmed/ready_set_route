@extends('County.slicing.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-12">
               <h1 class="heading">Teachers
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Teacher Email</th>
                        <th scope="col">School Name</th>
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                        <th scope="col">No. of Drivers</th>
                        <th scope="col">Status</th>
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($teachers as $teacher)
                     <tr>
                        
                        <td>{{$teacher->teacher_name}}</td>
                        <td>{{$teacher->email}}</td>
                        <td>{{$teacher->school_name}}</td>
                        <td>{{$teacher->parent_count}}</td>
                        <td>{{$teacher->student_count}}</td>
                        <td>{{$teacher->driver_count}}</td>
                        <td class="color-1">Active</td>
                        <td><a class="viewBtn" href="{{ route('county-admin-teacher-detail', $teacher->id)}}">View Details</a></td>
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