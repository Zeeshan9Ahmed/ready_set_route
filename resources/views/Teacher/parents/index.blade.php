@extends('Teacher.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
   @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

		 <div class="gentableWrap type-1 col-12">
               <h1 class="heading">Parents
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                       
                        <th scope="col">Parents Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">No. of Childs</th>
                        <th scope="col">No. of Drivers</th>
                        <th scope="col">Details</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ( $parents as $parent)
                     <tr>
                       
                        <td>{{$parent->parent_name}}</td>
                        <td>{{$parent->email}}</td>
                        <td>{{$parent->total_childs}}</td>
                        <td>{{$parent->total_drivers}}</td>
                        <td><a class="viewBtn" href="{{ route('teacher-admin-parent-detail', $parent->id) }}">View Details</a></td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
            <div class="col-12">
               <a class="genBtn type-3" href="{{route('teacher-admin-parent-view')}}" >Add Parent</a>           
            </div>
	</div>
</div>

@endsection