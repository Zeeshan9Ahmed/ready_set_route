@extends('dashboard.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		{{-- 
         <div class="detailBody col-12">
               <div class="detailContent">
                  <div class="text-box">
                     <h1 class="heading">Anna Baker</h1>
                     <p class="desc">Email: anabaker@example.com</p>
                     <p class="desc">Phone Number: +1 (123) - 123-1234</p>
                     <p class="desc">County: County 1</p>
                     <p class="desc">School: Lorem Lipsum School</p>
                     <p class="desc">Teacher Assigned: Jim Parker</p>
                     <p class="desc">Driver Assigned: Jhon Doe</p>                     
                     <p class="desc">Buss No.: ABC 123</p>
                     <p class="desc">Address: New York</p>
                     <p class="desc">Joining Date: 21- Jan-2020</p>
                  </div>
                  <div class="actionBtns">
                     <a class="genBtn" href="edit-student-detail.php">Edit</a>
                     <a class="genBtn" href="chat.php">Chat</a>
                     <a class="genBtn" href="invite-1.php">Invite</a>
                  </div>
               </div> 
            </div>
         
         --}}

            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">{{ $student_attendance->name}}
                  <!-- <a href="#!"><i class="fas fa-ellipsis-h"></i></a>-->
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        <th scope="col">Date</th>
                        {{--
                           <th scope="col">Time (From)</th>
                        <th scope="col">Time (To)</th>
                        --}}
                        <th scope="col">Driver</th>                           
                        <th scope="col">Bus No.</th>                                                      
                        <th scope="col">Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($student_attendance->attendance as $key=>$attendance)

                     <tr>
                        <td>{{ Carbon\Carbon::parse($attendance->date)->isoFormat('MMM Do YYYY') }}</td>
                        {{-- 
                           <td>7:05 am</td>
                        <td>9:05 am</td>
                           --}}
                        <td>{{$student_attendance->driver->name}}</td>
                        <td>{{$student_attendance->driver->vehicle?$student_attendance->driver->vehicle->vehicle_model:"-----"}}</td>
                        <td class="color-{{array_search($attendance->status, (config('readysetroute.student_attendance_status')))}}">{{$attendance->status}}</td>
                     </tr>
                     @endforeach
                     
                     
                  </tbody>
               </table>
            </div>
	</div>
</div>

@endsection