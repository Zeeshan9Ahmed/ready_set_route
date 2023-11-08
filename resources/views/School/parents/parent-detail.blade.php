@extends('School.slicing.master')
@section('contents')


<div class="gen-sec">
	<div class="container type-2">
		{{--  
         <div class="detailBody col-12">
               <div class="detailContent">
                  <div class="text-box">
                     <h1 class="heading">Michael David</h1>
                     <p class="desc">Email: ryanmichael@example.com</p>
                     <p class="desc">Phone Number: +1 (123) - 123-1234</p>
                     <p class="desc">School: Lorem Lipsum School</p>
                     <p class="desc">Address: New York</p>
                  </div>
                   <div class="actionBtns">
                     <a class="genBtn" href="edit-parent-detail.php">Edit</a>
                     <a class="genBtn" href="chat.php">Chat</a>
                     <a class="genBtn" href="invite-1.php">Invite</a>
                  </div>
               </div> 
            </div>
         
         --}}

            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Childrens
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Childrens Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">School Name</th>
                        <th scope="col">Drivers Name</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($children as $child)
                    <tr>
                        
                        <td>{{$child->child_name}}</td>
                        <td>{{$child->email}}</td>
                        <td>{{$child->teacher_name}}</td>
                        <td>{{$child->school_name}}</td>
                        <td>{{$child->driver_name?$child->driver_name:"-----"}}</td>
                     </tr>
                    @endforeach
                  </tbody>
               </table>
            </div>
	</div>
</div>

@endsection
