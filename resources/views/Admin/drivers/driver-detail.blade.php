@extends('dashboard.master')
@section('contents')


<div class="gen-sec">
	<div class="container type-2">
		{{-- 
         <div class="detailBody col-12">
               <div class="detailContent">
                  <div class="text-box">
                     <h1 class="heading">Ryan Michael</h1>
                     <p class="desc">Email: ryanmichael@example.com</p>
                     <p class="desc">Phone Number: +1 (123) - 123-1234</p>
                     <p class="desc">County: County 1</p>
                     <p class="desc">School: Lorem Lipsum School</p>
                     <p class="desc">Teacher Assigned: Jim Parker</p>
                     <p class="desc">No. of Students Assigned: 26</p>
                     <p class="desc">Buss No: ABCD-231</p>
                     <p class="desc">Address: New York</p>
                     <p class="desc">Joining Date: 21- Jan-2020</p>
                  </div>
                  <div class="actionBtns">
                     <a class="genBtn" href="edit-driver-detail.php">Edit</a>
                     <a class="genBtn" href="chat.php">Chat</a>
                     <a class="genBtn" href="invite-1.php">Invite</a>
                  </div>
               </div> 
            </div>
         
         --}}

            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Students
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Students Name</th>
                        <th scope="col">Student Email</th>
                        <th scope="col">Parents Name</th>
                        <th scope="col">Teachers Name</th>                           
                        <th scope="col">School Name</th>                                                      
                        <th scope="col">County Name</th>
                        
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
                       
                     </tr>
                    @endforeach
                  </tbody>
               </table>
            </div>
	</div>
</div>

@endsection