@extends('School.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-12">
               <h1 class="heading">Drivers
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Driver Name</th>
                        <th scope="col">Driver Email</th>
                        <th scope="col">No. of Parents</th>
                        <th scope="col">No. of Students</th>
                        <th scope="col">Status</th>
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($drivers as $driver)
                     <tr>
                        
                        <td>{{$driver->name}}</td>
                        <td>{{$driver->email}}</td>
                        <td>{{$driver->parent_count_of_students}}</td>
                        <td>{{$driver->assinged_student_count}}</td>
                        <td class="color-1">{{ $driver->status}}  {{ ($driver->status == 'invited')?$driver->is_accepted==1?"/ Accepted":"/ Pending" :""}}</td>
                        <td><a class="viewBtn" href="{{ route('school-admin-driver-detail', $driver->id) }}">View Details</a></td>
                     </tr>
                    @endforeach
                     
                  </tbody>
               </table>
            </div>
            
               <div class="col-12">
               <a class="genBtn type-3" href="{{route('school-admin-invite-drivers') }}" >Invite</a>           
            </div>
               
	</div>
</div>

@endsection