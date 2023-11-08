@extends('School.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		 <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Parents
                 
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Parents Name</th>
                        <th scope="col">Parents Email</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">No. of Childrens</th>
                        <th scope="col">No. of Drivers</th>
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($parents as $parent) 
                    <tr>
                        
                        <td>{{ $parent->parent_name}}</td>
                        <td>{{ $parent->email}}</td>
                        <td>{{ $parent->teacher_name}}</td>
                        <td>{{ $parent->children_count}}</td>
                        <td>{{ $parent->driver_count}}</td>
                        <td><a class="viewBtn" href="{{ route('school-admin-parent-detail',$parent->id) }}">View Details</a></td>

                     </tr>
                    @endforeach
                     
                  </tbody>
               </table>
            </div>
           
	</div>
</div>

@endsection