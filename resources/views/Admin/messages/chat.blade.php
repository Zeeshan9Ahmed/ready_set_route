
@extends($view)
@section('contents')

<div class="gen-sec chat-page-chat-box">
	<div class="container type-2">
		<div class="row justify-content-center">
			<div class="gentableWrap type-1 col-10">
				<h1 class="heading">
					<div class="chatImg">
						<a href="#!" class="imgBox">
							@if (!$user->image)
							<img src="{{ asset('public/avatar.png')}}" alt="img">
							@else
							<img src="{{$user->image}}" alt="img">

							@endif
						</a>
						<p id="user_name">{{$user->name}}</p>
					</div>
					
				</h1>

				<div class="chat-box-body">
					<div class="messages-box" id="chat-html">

						

					</div>
				</div>  

				<div class="sender-message-box">
					<div class="wrtie-message">
							<div class="form-group">
								<!-- <textarea>Type your message......</textarea> -->
								<input type="text" name="message" id="message" placeholder="Type your message......" required>
								<div >

									<button type="button" id="send_message" class="send-btn">
										
										<i class="fas fa-paper-plane"></i>
	
									</button>
								</div>
							</div>
						
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


@endsection

@section('additional-scripts')
<script src="https://cdn.socket.io/4.4.1/socket.io.min.js" integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous"></script>
<script>


	var found = {};
	$('[data-id]').each(function() {

		var $this = $(this);

		if (found[$this.data('id')]) {
			$this.remove();
		} else {
			found[$this.data('id')] = true;
		}
	});

	// const socket = io.connect("http://localhost:3003");
	const socket = io.connect("https://server1.appsstaging.com:3071");
	socket.on("connect", () => {
		console.log(socket.connected); // true
	});

	socket.on("error", (error_messages) => {
		not('Something went wrong', 'error');
	});

	socket.emit('get_messages', {
		"sender_id": "{{ $sender_id }}",
		"reciever_id": "{{ $reciever_id }}",
		"sender_type": "{{ $sender_type }}",
		"reciever_type": "{{ $reciever_type }}"
	});

	socket.on("disconnect", () => {
		console.log(socket.connected); // false
	});

	$("#send_message").click(function() {

		var message = $("#message").val();
		let sender_id = "{{ $sender_id}}";
		let reciever_id = "{{ $reciever_id}}";
		let sender_type = "{{ $sender_type}}";
		let reciever_type = "{{ $reciever_type }}";
		if (! message )
		{
			alert('Message Can not be Empty')
			return;
		}
		// console.log(message,sender_id, sender_type ,reciever_id , reciever_type)
		// return;
		

		socket.emit("send_message", {
			sender_id: sender_id,
			reciever_id: reciever_id,
			message: message,
			// chat_type: 'text',
			sender_type: sender_type,
			reciever_type: reciever_type
		});
	})


	socket.on("error", (messages) => {
		// console.log('messages *** ', messages);
	})

	socket.on("response", (messages) => {
		// append single msg for chat
		
		if (messages.object_type == "get_message") {

			let val = messages.data;
			
			// return;
			$("#message").val('');
			let html = '';
			if (val.sender_id == "{{ $sender_id }}" && val.sender_type == "{{ $sender_type  }}") {
					var class_name = 'sender';
				
				} else {
					var class_name = 'receiver';
				}

				html +=
				`<div class="message ${class_name}">
					<p class="message-content">
						${val.message} <br>
						${formatDate(val.created_at)}
					</p>
					<div class="img-box">
						<img src="" class="profile-img">
					</div>
				</div> `;

			
			$('#chat-html').append(html);

		} else if (messages.object_type == "get_messages") {
			// all chat append
			// console.log(messages)
			// var user_name = '';
			var html = '';
			$(messages.data).each(function(i, val) {
				// console.log(val.name)
				if (val.sender_id == "{{ $sender_id }}" && val.sender_type == "{{ $sender_type  }}") {
					var class_name = 'sender';
					
				} else {
					var class_name = 'receiver';
				}
				
					var url = "";
				
				html +=
				`<div class="message ${class_name}">
					<p class="message-content">
						${val.message} <br>
						${formatDate(val.created_at)}
					</p>
					<div class="img-box">
						<img src="${url}" class="profile-img">
					</div>
				</div> `;

			});
			// console.log(html)
			$('#chattingContentBox').removeClass('d-none');
			$('#chattingContentBoxImg').addClass('d-none');
			$("#chat-html").html(html);
		}
		scrollToBottom();
	});

	$(document).on('click', '.dropdown-button', function() {
		$(this).next().toggleClass("active");
	});

	$(document).on('click', '.replyBtn', function() {
		$(".dropdown-list-content").removeClass("active");
	});




	$(document).on('click', '.replyBtn', function() {
		$(".replyBox").addClass("active");
		var message = $(this).attr('message');
		var chat_id = $(this).attr('chat-id');
		$('#chatId').val(chat_id);
		$('#reply-msg').empty().text(message);
	});

	$(document).on('click', '.closeReply', function() {
		$(".replyBox").removeClass("active");
		$('#reply-msg').empty();
		$('#chatId').val(0);
	});


	$(".user-lists").click(function() {
		var id = $(this).attr('data-id');
		$('#recieverId').val(id);

		socket.emit('get_messages', {
			"sender_id": "",
			"reciever_id": id
		});

	});

	function formatDate(date) {
		var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		hours = d.getHours();
		minutes = d.getMinutes();
		seconds = d.getSeconds();

		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;

		var g_date = [year, month, day].join('-');
		var g_time = [hours, minutes].join(':');

		return g_date + ' ' + g_time;
	}

	// $(".chatting-item").click(function() {
	// 	$(".chatting-item").toggleClass("active");
	// });

	$(".chatting-item").click(function() {
		$(this).addClass('active')
			.parent().siblings().children().removeClass('active');
	});

	function scrollToBottom() {
		var messages = document.getElementById('chat-html');
		messages.scrollTop = messages.scrollHeight;
	}
</script>
@endsection