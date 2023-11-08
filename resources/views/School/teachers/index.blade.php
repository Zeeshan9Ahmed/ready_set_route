@extends('School.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
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
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($teachers as $teacher) 
                    <tr>
                        
                        <td>{{ $teacher->teacher_name}}</td>
                        <td >{{$teacher->email}}</td>
                        <td>{{ $teacher->total_parents_created}}</td>
                        <td>{{ $teacher->total_students_created}}</td>
                        
                        <td><a class="viewBtn" href="{{ route('school-admin-teacher-detail',$teacher->id) }}">View Details</a></td>
                     </tr>
                    @endforeach
                     
                  </tbody>
               </table>
            </div>
            
	</div>
</div>

@endsection