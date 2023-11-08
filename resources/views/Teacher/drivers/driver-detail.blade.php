@extends('Teacher.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
      {{-- 
         
		<div class="detailBody col-12">
         <div class="detailContent">
            <div class="text-box">
               <h1 class="heading">{{$driver->name}}</h1>
               <p class="desc">Email: {{$driver->email}}</p>
               <p class="desc">Phone Number: {{$driver->phone}}</p>
               <p class="desc">No. of Students Assigned: {{$driver->assigned_student_count}}</p>
               <p class="desc">Buss No: ABCD-231</p>
               <p class="desc">Address: {{$driver->address}}</p>
               <p class="desc">Joining Date: {{$driver->joining_date}}</p>
            </div>
            
         </div> 
      </div>

         
         --}}
      <div class="gentableWrap type-1 col-12">
         <h1 class="heading">Students</h1>  
         <table class="display nowrap dataTable" id="examp" style="width:100%">
            <thead class="thead-dark">
               <tr>
                  <th scope="col">Students Name</th>
                  <th scope="col">Students Email</th>
                  <th scope="col">Parents Name</th>
                  <th scope="col">Teachers Name</th>                           
                  <th scope="col">School Name</th>                                                      
               </tr>
            </thead>
            <tbody>
               @foreach ($students as $student)
               <tr>
                  <td>{{ $student->child_name}}</td>
                  <td>{{ $student->email}}</td>
                  <td>{{ $student->parent_name}}</td>
                  <td>{{ $student->teacher_name}}</td>
                  <td>{{ $student->school_name}}</td>
               </tr>
               @endforeach
               
            </tbody>
         </table>
      </div>
	</div>
</div>

@endsection