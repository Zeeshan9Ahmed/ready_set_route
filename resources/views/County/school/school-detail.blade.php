@extends('County.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		{{-- 
         <div class="detailBody col-12">
               <div class="detailContent">
                  <div class="text-box">
                     <h1 class="heading">Lorem Ipsum County</h1>
                     <p class="desc">Email: countyabc@example.com</p>
                     <p class="desc">Phone Number: +1 (123) - 123-1234</p>
                     <p class="desc">County: County 1</p>
                     <p class="desc">Address: New York</p>
                     <p class="desc">Joining Date: 21- Jan-2020</p>
                  </div>
                  <div class="actionBtns">
                     <a class="genBtn" href="edit-school-detail.php">Edit</a>
                     <a class="genBtn" href="chat.php">Chat</a>
                     <a class="genBtn" href="invite-2.php">Invite</a>
                  </div>
               </div> 
            </div>
         
         --}}

            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Teachers
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Teacher Email</th>
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                        <th scope="col">No. of Drivers</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($teachers as $teacher)
                     <tr>
                        
                        <td>{{$teacher->teacher_name}}</td>
                        <td>{{$teacher->email}}</td>
                        <td>{{$teacher->parent_count}}</td>
                        <td>{{$teacher->student_count}}</td>
                        <td>{{$teacher->driver_count}}</td>
                     </tr>
                     
                  @endforeach
                  </tbody>
               </table>
            </div>
	</div>
</div>


@endsection