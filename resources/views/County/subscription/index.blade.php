@extends('County.slicing.master')
@section('contents')
​
<style>
  .require-validation .form-check {
      position: absolute;
    top: 10px;
    right: 10px;
}
   
.require-validation .form-check-input {
    width: 22px!important;
    height: 22px!important;
    border: 2px solid #000!important;
    cursor: pointer!important;

}
.require-validation input[type="radio"] {
    display: inline;
    place-content: center;
}
.require-validation .form-check-input:checked {
    background-color: #431600;
    border-color: #431600;
}
.require-validation .form-control {
    width: 100%;
    height: 55px;
    border-radius: 30px;
    background: #f1f1f1;
    font-size: 20px;
    font-weight: 500;
    color: #000000;
    border: 0;
    outline: none;
    padding-left: 25px;
}
.require-validation .form-row.row {
   max-width: 900px;
}
.require-validation .form-control:focus {
    color: #000;
    background-color: #f1f1f1;
    border-color: #f1f1f1;
    box-shadow: none;
}
.require-validation .control-label {
   font-size: 18px;
    font-weight: 700;
    color: #431500;
    padding-bottom: 10px;
}

.require-validation .sendBtn {
    width: 100%;
    height: 55px;
    border-radius: 30px;
    background: #431500;
    font-size: 20px;
    font-weight: 600;
    color: #ffff;
    border: 0;
}
.require-validation .sendBtn:hover {
   background: #431500 ;
}
</style>
<div class="gen-sec">
   <div class="container type-2">
      <div class="row">

      @if($message)
            <div class="alert alert-danger col-10">
                {{ $message }}
            </div>
        @endif
         <div class="gentableWrap type-1 col-10" id="subscription-tab">
            <h1 class="heading">Subscription

            </h1>
            <form role="form" action="{{ route('plan.post') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                @csrf

                <div class="subscriptionWrap row">

                    @forelse($plans as $plan)
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                      <div class="col-4">
                            <div class="subscriptCard">
                               <div class="textBox mb-4">
                                  <h1 class="title">{{ ucwords($plan->title) }}</h1>
                                  <p class="desc">{{ ucfirst($plan->description) }}</p>
                                  <p class="price">
                                     <span class="d-flex align-items-center"> @if($plan->off > 0) ${{$plan->off}} @else ${{$plan->price}} @endif /
                                        <span class="priceOffer">
                                           <span class="lastPrice mb-1">@if($plan->off > 0) ${{$plan->price}} @else ${{$plan->off}} @endif</span>
                                           <span class="discountRate">80% off!</span>
                                        </span>
                                     </span>
                                  </p>
                               </div>

                               <ul class="featureList">
                                 @foreach($plan->features as $feature) 
                                 <li>Lorem ipsum dolor sit amet</li>
                                  @endforeach
                               </ul>
                               <div class="form-check">
                                 <input class="form-check-input" type="radio" name="plan_id" value="{{ $plan->id }}" required>
                                 <!-- <label class="form-check-label" for="flexRadioDefault1">
                                 </label> -->
                                 </div>
                               <!-- <div class="form-check">
                                 <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                 <label class="form-check-label" for="flexCheckDefault">
                                 </label>
                              </div> -->
                              
                            </div>
                      </div>
                      @empty
                      <div class="col-12">
                         <p>Plan not found.</p>
                      </div>
                      @endforelse

                    <div class='form-row row mt-5'>
                       <div class='col-xs-12 col-md-6 form-group required'>
                          <label class='control-label'>Name on Card</label>
                          <input class='form-control' size='4' type='text'>
                       </div>
                       <div class='col-xs-12 col-md-6 form-group required'>
                          <label class='control-label'>Card Number</label>
                          <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                       </div>
                    </div>
                    <div class='form-row row'>
                       <div class='col-xs-12 col-md-4 form-group cvc required'>
                          <label class='control-label'>CVC</label>
                          <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                       </div>
                       <div class='col-xs-12 col-md-4 form-group expiration required'>
                          <label class='control-label'>Expiration Month</label>
                          <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                       </div>
                       <div class='col-xs-12 col-md-4 form-group expiration required'>
                          <label class='control-label'>Expiration Year</label>
                          <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                       </div>
                    </div>
                    <div class="form-row row">
                       <div class="col-xs-12">
                          <button class="btn btn-primary btn-lg btn-block sendBtn" type="submit">Pay Now</button>
                       </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
