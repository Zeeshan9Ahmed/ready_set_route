@extends('Teacher.slicing.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		

            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Details
                  <!-- <a href="#!"><i class="fas fa-ellipsis-h"></i></a>-->
                  <div class="actionBtns" >
                     <a class="btn btn-sm btn-danger" href="{{ route('teacher-admin-delete-student', $student_id)}}" onclick="return confirm('Are You Sure You Want to Delete it.');">Delete Child</a>
                  </div>
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