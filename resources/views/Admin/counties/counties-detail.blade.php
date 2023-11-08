@extends('dashboard.master')
@section('contents')


<div class="gen-sec">
	<div class="container type-2">
		
         <div class="detailBody col-12">
               <div class="detailContent">
                  <div class="text-box">
                     <h1 class="heading">{{$county->county_name}}</h1>
                     <p class="desc">Name: {{ $admin?($admin->name?$admin->name:"---------"):"---------"  }}</p>
                     <p class="desc">Email: {{ $admin?($admin->email?$admin->email:"---------"):"---------"  }}</p>
                     <p class="desc">Phone Number: {{ $admin?($admin->phone?$admin->phone:"---------"):"---------"  }}</p>
                     <p class="desc">County: {{$county->county_name}}</p>
                     {{-- 
                        <p class="desc">Address: New York</p>
                     <p class="desc">Joining Date: 21- Jan-2020</p>
                     <p class="desc">Subscribe Package: Enterprise</p>
                        --}}
                  </div>
                  {{-- 
                     <div class="actionBtns">
                     <a class="genBtn" href="edit-county-detail.php">Edit</a>
                     <a class="genBtn" href="chat.php">Chat</a>
                     <a class="genBtn" href="invite-2.php">Invite</a>
                  </div>
                     --}}
               </div> 
            </div>
         
         
      
            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Schools
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Schools Name</th>
                        <th scope="col">No. of Teachers</th>
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                        <th scope="col">No. of Drivers</th>
                        
                       
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($schools as $school)          
                    <tr>
                        
                        <td>{{$school->school_name}}</td>
                        <td>{{$school->teacher_count}}</td>
                        <td>{{$school->parent_count}}</td>
                        <td>{{$school->student_count}}</td>
                        <td>{{$school->driver_count}}</td>
                        
                       
                     </tr>
                    @endforeach
                     
                  </tbody>
               </table>
            </div>
	</div>
</div>

@endsection