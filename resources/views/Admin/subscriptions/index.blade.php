@extends('dashboard.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		<div class="row">
         <div class="gentableWrap type-1 col-10" id="subscription-tab">
            <h1 class="heading">Subscription</h1> 

            <div class="subscriptionWrap row">
               
            @foreach($plans as $plan)
            <div class="col-4">
                  <div class="subscriptCard">
                     <div class="textBox mb-4">
                        <h1 class="title">{{$plan->title}}</h1>
                        <p class="desc">{{$plan->description}}</p>
                        <p class="price">
                           <span class="d-flex align-items-center">${{$plan->off}}/
                              <span class="priceOffer">
                                 <span class="lastPrice mb-1">$ {{ $plan->price}}</span>
                                 <span class="discountRate">80% off!</span>
                              </span>
                           </span>
                        </p>
                     </div>

                     <ul class="featureList">
                        @foreach($plan->features as $feature)
                        <li>{{$feature->feature}}</li>
                        @endforeach
                        
                     </ul>
                     <div class="btnWrap">
                        <a href="{{ url('admin/edit-package', $plan->id)}}" class="editBtn1">
                           <img src="{{asset('public/edit.png')}}"  alt="">
                        </a>
                        <a href="{{ url('admin/delete-package', $plan->id)}}" onclick="return confirm('Are you sure you want to delete?');" class="editBtn1">
                        <img src="{{asset('public/trash.png')}}" alt="">
                        </a>
                     </div>
                  </div>
               </div>

               @endforeach

            </div> 

            <div class="actionBtns">
               <a class="genBtn" href="{{ url('admin/package') }}" >Upload Packages</a>
               <a class="genBtn" href="{{ url('admin/subscription-history')}}" >View History</a>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection