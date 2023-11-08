@extends('School.slicing.master')
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
                        <th scope="col">Driver Name</th>
                       {{-- 
                        <th scope="col">Attendence</th>
                        --}}
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ( $students as $student)
                    <tr>
                        
                        <td>{{$student->student_name}}</td>
                        <td>{{$student->email}}</td>
                        <td>{{$student->parent_name}}</td>
                        <td>{{$student->teacher_name}}</td>
                        <td>{{$student->driver_name?$student->driver_name:"---"}}</td>
                        {{-- 
                           <td class="color-1">Present</td>
                           --}}
                        <td><a class="viewBtn" href="{{ route('school-admin-student-detail',1) }}">View Details</a></td>

                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
           
       </div>
</div>

@endsection