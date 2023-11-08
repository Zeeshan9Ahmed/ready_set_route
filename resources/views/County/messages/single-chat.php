@extends('County.slicing.master')
@section('contents')
<div class="gen-sec chat-page-chat-box">
	<div class="container type-2">
		<div class="row justify-content-center">
			<div class="gentableWrap type-1 col-10">
				<h1 class="heading">
					<div class="chatImg">
						<a href="#!" class="imgBox">
							<img src="assets/images/noti-img-1.png" alt="img">
						</a>
						<p>County 1</p>
					</div>
					<a href="#!" class="filter-1"><i class="fas fa-ellipsis-h"></i>
						<span class="genDropdown">
							<button>Edit</button>
							<button>Remove</button>
						</span>
					</a>
				</h1>

				<div class="chat-box-body">
					<div class="messages-box">
						<div class="message sender">
							<div class="img-box">
								<img src="assets/images/noti-img-1.png" class="profile-img">
							</div>
							<p class="message-content">How are you Lorem ipsum, dolor sit amet consectetur adipisicing elit. Placeat!</p>
						</div>   
						<div class="message receiver">
							<p class="message-content">Fine Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis.</p>
							<div class="img-box">
								<img src="assets/images/noti-img-2.png" class="profile-img">
							</div>
						</div>   
						<div class="message sender">
							<div class="img-box">
								<img src="assets/images/noti-img-1.png" class="profile-img">
							</div>
							<p class="message-content">What about you! Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed.</p>
						</div>  
						<div class="message receiver">
							<p class="message-content">Fine Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis.</p>
							<div class="img-box">
								<img src="assets/images/noti-img-2.png" class="profile-img">
							</div>
						</div> 
						<div class="message sender">
							<div class="img-box">
								<img src="assets/images/noti-img-1.png" class="profile-img">
							</div>
							<p class="message-content">What about you! Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed.</p>
						</div> 
					</div>
				</div>  

				<div class="sender-message-box">
					<div class="wrtie-message">
						<form>
							<div class="form-group">
								<!-- <textarea>Type your message......</textarea> -->
								<input type="text" placeholder="Type your message......">
								<a href="#!" class="send-btn">
									<i class="fas fa-paper-plane"></i>
								</a>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection