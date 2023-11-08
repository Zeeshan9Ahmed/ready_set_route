@extends('County.slicing.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-12">
               <h1 class="heading">Students
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Student Name</th>
                        <th scope="col">Student Email</th>
                        <th scope="col">Parents Name</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">School Name</th>                           
                        <th scope="col">County Name</th>                                                      
                        <th scope="col">No. of Drivers</th>
                        {{-- 
                           <th scope="col">Status</th>
                           --}}
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($students as $student)
                     <tr>
                        
                        <td>{{$student->student_name}}</td>
                        <td>{{$student->email}}</td>
                        <td>{{$student->parent_name}}</td>
                        <td>{{$student->teacher_name}}</td>
                        <td>{{$student->school_name}}</td>
                        <td>{{$student->county_name}}</td>
                        <td>{{$student->driver_count}}</td>
                        {{-- 
                           <td class="color-3">Absent</td>
                           --}}
                        <td><a class="viewBtn" href="{{ route('county-admin-student-detail', $student->id) }}">View Details</a></td>
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