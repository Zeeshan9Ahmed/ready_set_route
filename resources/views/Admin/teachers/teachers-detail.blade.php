@extends('dashboard.master')
@section('contents')

<div class="gen-sec" id="teacher-detail-tab">
	<div class="container type-2">
		{{--  
         
         <div class="detailBody col-12">
               <div class="detailContent">
                  <div class="text-box">
                     <h1 class="heading">James Robert</h1>
                     <p class="desc">Email: countyabc@example.com</p>
                     <p class="desc">Phone Number: +1 (123) - 123-1234</p>
                     <p class="desc">County: County 1</p>
                     <p class="desc">School: Lorem Lipsum School</p>
                     <p class="desc">Address: New York</p>
                     <p class="desc">Joining Date: 21- Jan-2020</p>
                  </div>
                  <div class="actionBtns">
                     <a class="genBtn" href="edit-teacher-detail.php">Edit</a>
                     <a class="genBtn" href="chat.php">Chat</a>
                     <a class="genBtn" href="invite-1.php">Invite</a>
                     <button class="genBtn" data-bs-toggle="modal" data-bs-target="#assignModal">
                         Assign To
                      </button>
                  </div>
               </div> 
            </div>
         --}}

            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Parents
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Parent Name</th>
                        <th scope="col">Parent Email</th>
                       
                        <th scope="col">School Name</th>
                        <th scope="col">County Name</th>
                        <th scope="col">No. of Students</th>
                        <th scope="col">No. of Drivers</th>
                        
                     
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($parents as $parent) 
                    <tr>
                        
                        <td>{{$parent->parent_name}}</td>
                        <td>{{$parent->email}}</td>
                       
                        <td>{{$parent->school_name}}</td>
                        <td>{{$parent->county_name}}</td>
                        <td>{{$parent->student_count}}</td>
                        <td>{{$parent->driver_count}}</td>
                       
                       
                     </tr>
                    @endforeach
                     
                  </tbody>
               </table>
            </div>
	</div>
</div>

@endsection