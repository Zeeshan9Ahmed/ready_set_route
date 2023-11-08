@extends('dashboard.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		 <div class="row">
               <div class="gentableWrap mt-2 col-8">
                  <h1 class="heading">Notifications
                     
                  </h1> 

                  {{-- 
                     
                     <div class="notificationWrap">
                     <div class="notificationItem"> 
                        <a href="#!" class="imgBox">
                           <img src="assets/images/noti-img-1.png" alt="img">
                        </a>
                        <a href="#!" class="textBox">
                           <span>
                              <h1 class="title"><span>County 01</span> accepted your invite. </h1>
                              <p class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                           </span>
                           <p class="date">04 Jan, 2022</p>
                        </a>                    
                     </div>

                     <div class="notificationItem"> 
                        <a href="#!" class="imgBox">
                           <img src="assets/images/noti-img-2.png" alt="img">
                        </a>
                        <a href="#!" class="textBox">
                           <span>
                              <h1 class="title"><span>County 07</span> accepted your invite. </h1>
                              <p class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                           </span>
                           <p class="date">11 Jan, 2022</p>
                        </a>                    
                     </div>

                     <div class="notificationItem"> 
                        <a href="#!" class="imgBox">
                           <img src="assets/images/noti-img-3.png" alt="img">
                        </a>
                        <a href="#!" class="textBox">
                           <span>
                              <h1 class="title"><span>County 12</span> accepted your invite. </h1>
                              <p class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                           </span>
                           <p class="date">16 Jan, 2022</p>
                        </a>                    
                     </div>

                     <div class="notificationItem"> 
                        <a href="#!" class="imgBox">
                           <img src="assets/images/noti-img-4.png" alt="img">
                        </a>
                        <a href="#!" class="textBox">
                           <span>
                              <h1 class="title"><span>Lorem Ipsum School</span> accepted your invite. </h1>
                              <p class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                           </span>
                           <p class="date">21 Jan, 2022</p>
                        </a>                    
                     </div>

                     <div class="notificationItem"> 
                        <a href="#!" class="imgBox">
                           <img src="assets/images/noti-img-5.png" alt="img">
                        </a>
                        <a href="#!" class="textBox">
                           <span>
                              <h1 class="title"><span>Lorem ipsum Driver</span> accepted your invite. </h1>
                              <p class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                           </span>
                           <p class="date">04 Jan, 2022</p>
                        </a>                    
                     </div>
                  </div> 
                     --}}
               </div>

               <div class="col-4 mt-2 ">
                  <div class="gentableWrap">
                     <h1 class="heading">Send Push Notification
                       
                     </h1> 
                     <form class="push-msg" method="POST" action="{{route('admin_send_notification')}}">
                        @csrf
                       <div class="form-group">
                        <select name="type">
                           <option disabled selected> Select</option>
                           <option value="all">All</option>
                           <option value="county">Counties</option> 
                           <option value="school">Schools</option>
                           <option value="driver">Drivers</option>
                           <option value="teacher">Teachers</option>                                                       
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