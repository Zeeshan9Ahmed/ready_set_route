@extends('Teacher.slicing.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		 <div class="row">
               <div class="gentableWrap mt-2 col-8">
                  <h1 class="heading">Notifications
                    
                  </h1> 

                  <div class="notificationWrap">
                     @forelse($notifications as $notification)
                     <div class="notificationItem"> 
                        <a href="#!" class="imgBox">
                           <img src="{{ $notification->image }}" alt="img">
                        </a>
                        <a href="#!" class="textBox">
                           <span>
                              <h1 class="title"><span>{{$notification->name }} : </span> {{$notification->title}}. </h1>
                              <p class="desc">{{$notification->description}}</p>
                           </span>
                           <p class="date">{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
                        </a>                    
                     </div>
                     @empty
                     @endforelse

                  </div>  
               </div>

               <div class="col-4 mt-2 ">
                  <div class="gentableWrap">
                     <h1 class="heading">Send Push Notification
                      
                     </h1> 
                     <form class="push-msg" method="POST" action="{{route('teacher_send_notification')}}">
                        @csrf
                       <div class="form-group">
                        <select name="type">
                           <option disabled selected>Select</option>
                           <option value="all">All</option>
                           {{-- 
                              <option value="county">Counties</option>
                              <option value="school">Schools</option>
                              --}} 
                                                                              
                           <option value="parent">Parents</option>                                                       
                           <option value="student">Students</option>                                                      
                        </select>
                     </div>
                     <div class="form-group">
                        <input type="text" name="title" placeholder="Title">
                     </div>
                     <div class="form-group">
                        <textarea name="description" placeholder="Description"></textarea>
                     </div>
                     <div class="form-group">
                        <button class="sendBtn" type="submit">Send Notification</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
	</div>
</div>

@endsection