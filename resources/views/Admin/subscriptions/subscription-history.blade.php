@extends('dashboard.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-12">
               <h1 class="heading">Subscription History
                  
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        
                        <th scope="col">County Name</th>
                        <th scope="col">Administrator Name</th>
                        <th scope="col">Package</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Subscribe Date</th>
                        <th scope="col">Expiry Date</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($purchased_plans as $purchased_plan)
                     
                     <tr>
                        <td>{{$purchased_plan->county_name}}</td>
                        <td>{{$purchased_plan->user_name}}</td>
                        <td>{{$purchased_plan->title}}</td>
                        <td>{{$purchased_plan->price}}</td>
                        @if($purchased_plan->end_date < Carbon\Carbon::today())
                        <td class="color-1">Expired</td>
                        @else
                        <td class="color-2">Not Expired</td>
                        @endif
                        <td>{{ Carbon\Carbon::parse($purchased_plan->created_at)->isoFormat('MMM Do YYYY') }}</td>
                        <td>{{ Carbon\Carbon::parse($purchased_plan->end_date)->isoFormat('MMM Do YYYY') }}</td>
                        
                     </tr>
                     @endforeach
                     
                     
                    
                     
                  </tbody>
               </table>
            </div>
	</div>
</div>

@endsection
