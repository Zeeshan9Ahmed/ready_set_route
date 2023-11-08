@extends('dashboard.master')

@section('contents')

<div class="gen-sec">

	<div class="container type-2">
		<div class="row secBreak">

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

               <div class="gentableWrap type-1 col-6 genCol101">
                  <h1 class="heading">Create New State </h1>

                  <form class="upload-pkg-form push-msg row" method="post" action="{{route('admin-save-state')}}">
                    @csrf

                     <div class=" col-12 form-group">
                     @error('state_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <input type="text" placeholder="State" name="state_name" required>
                     </div>


                     <div class="col-12 form-group mt-3">
                        <button class="sendBtn">Save</button>
                     </div>


                  </form>


               </div>

               <div class="gentableWrap type-1 col-6 genCol101">
                  <h1 class="heading">Add New County </h1>

                  <form class="upload-pkg-form push-msg row" method="post" action="{{route('admin-save-county')}}">
                    @csrf
                    <div class="form-group type-2 mb-3">
                     <select id="state" name="state_id" required>
                        <option value="" disabled selected>Select State</option>
                         @foreach ($states as  $key => $state)
                        <option value="{{$state->id}}">{{  $state->state_name }}</option>
                        @endforeach
                     </select>
                     </div>
                     <div class=" col-12 form-group">

                     @error('county_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                        <input type="text" placeholder="County Name" name="county_name" required>
                     </div>
                     <div class="col-12 form-group mt-3">
                        <button class="sendBtn">New County</button>
                     </div>


                  </form>
        
               </div>

            </div>







            <div class="row">
                <div class="gentableWrap type-1 col-6 genCol101">
                 
            <div class="gentableWrap type-1 col-12 m-0 genCol101">
			<h1 class="heading">All States</h1>
			<table class="display nowrap dataTable" id="examp" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th scope="col">State Name</th>
						<th scope="col">Details</th>
					</tr>
				</thead>
				<tbody>

					@if ( $states->count() > 0 )
					@foreach ( $states as $state)
					<tr>
						<td>{{$state->state_name}}</td>
                        <td><a class="viewBtn" href="{{ route('admin-get-state',$state->id)}}">Edit State</a></td>
					</tr>

                    @endforeach
					@else
					<th>No Data Found</th>
					@endif
				</tbody>
			</table>
		        </div>

               </div>

               <div class="gentableWrap type-1 col-6 genCol101">
                  
                  <div class="gentableWrap type-1 col-12 m-0 genCol101">
			<h1 class="heading">All Counties</h1>
			<table class="display nowrap dataTable" id="examp" style="width:100%">
				<thead class="thead-dark">
					<tr>
						<th scope="col">County Name</th>
						<th scope="col">Details</th>
					</tr>
				</thead>
				<tbody>

					@if ( $counties->count() > 0 )
					@foreach ( $counties as $county)
					<tr>
						<td>{{$county->county_name}}</td>
                        <td><a class="viewBtn" href="{{ route('admin-get-county',$county->id)}}">Edit County</a></td>
					</tr>

                    @endforeach
					@else
					<th>No Data Found</th>
					@endif
				</tbody>
			</table>
		</div>
               </div>

            </div>
	</div>
</div>


@endsection


@section('additional-scripts')
<script>


</script>
@endsection
