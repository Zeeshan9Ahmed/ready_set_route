@extends('dashboard.master')
@section('contents')
<style>
   .stateBtn {
    width: 205px;
    height: 55px;
    font-size: 20px!important;
    color: #fff!important;
    border-radius: 30px;
    background: #431500;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-12">
			<h1 class="heading">
                <a href="{{ route('admin-state-management') }}" class="stateBtn">Add New State</a>
            </h1>
			<h1 class="heading">States
				
			</h1>  
			<table class="display nowrap dataTable" id="examp" style="width:100%">
				<thead class="thead-dark">
					<tr>
						
						<th scope="col">State Name</th>
						<th scope="col">No. of Counties</th>
						<th scope="col">No. of Schools</th>
						<th scope="col">No. of Teachers</th>
						<th scope="col">No. of Parents</th>
						<th scope="col">No. of Students</th>
						<th scope="col">No. of Drivers</th>
						<th scope="col">Status</th>
						<th scope="col">Details</th>
					</tr>
				</thead>
				<tbody>

					@if ( $states->count() > 0 )
					@foreach ( $states as $state)
					<tr>
						<td>{{$state->state_name}}</td>
                        <td>{{$state->total_counties}}</td>
						<td>{{$state->school_count}}</td>
						<td>{{$state->teacher_count}}</td>
						<td>{{$state->parent_count}}</td>
						<td>{{$state->student_count}}</td>
						<td>{{$state->driver_count}}</td>
						<td class="color-1">Active</td>
						<td><a class="viewBtn" href="{{ route('admin-state-detail',$state->id)}}">View Details</a></td>
					</tr>

                    @endforeach
					@else
					<th>No Data Found</th>
					@endif
				</tbody>
			</table>
		</div>


		{{--
			<div class="col-12">
			<a class="genBtn type-3" href="invite-2.php">Invite</a>          
		</div>
			
			--}}
	</div>
</div>


@endsection