@extends('Teacher.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		<div class="detailBody col-12">
               <div class="detailContent">
                  
                   <div class="actionBtns" >
                     <a class="genBtn" href="{{route('teacher-admin-child-view', $parent_id)}}">Add Child</a>
                  </div>
               </div> 
            </div>

            <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Childrens
               <div class="actionBtns" >
                     <a class="btn btn-sm btn-danger" href="{{ route('teacher-admin-delete-parent', $parent_id)}}" onclick="return confirm('Are You Sure You Want to Delete it.');">Delete Parent</a>
                  </div>
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">Childrens Name</th>
                        <th scope="col">Childrens Email</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">School Name</th>
                        <th scope="col">Drivers Name</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ( $children as $child )
                     
                     <tr>
                        
                        <td>{{ $child->child_name }}</td>
                        <td>{{ $child->child_email }}</td>
                        <td>{{ $child->teacher_name }}</td>
                        <td>{{ $child->school_name }}</td>
                        <td>{{ $child->driver_name }}</td>
                       
                     </tr>
                     @endforeach
                     
                  </tbody>
               </table>
            </div>
	</div>
</div>

@endsection