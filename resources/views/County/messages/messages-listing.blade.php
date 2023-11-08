@extends('County.slicing.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
               <div class="searchRow">
                  <form class="row">
                     <div class="col-3 form-group m-0">
                        <input type="search" id="keyword" name="keyword" min="3" placeholder="Search" required>
                        

                     </div>
                     <div class="col-2 form-group m-0">
                        <button class="genBtn" id="search" type="button">Search</button>
                     </div>
                  </form>
               </div>


               <div class="row">
                  <div class="gentableWrap mt-2 col-8">
                     <h1 class="heading">Messages
                        
                     </h1> 

                     <div class="notificationWrap">
                     @if($chat_list && count($chat_list) > 0 )
                        @foreach ( $chat_list as $chat )
                        <div class="notificationItem"> 
                           <a href="#!" class="imgBox">
                           <img src="{{$chat->image ? $chat->image : asset('public/avatar.png') }}" alt="img">
                           </a>

                           <a href="{{ route('county_chat',[$chat->user_id,  $chat->role] ) }}"  class="textBox">
                              <span>
                                 <h1 class="title">{{$chat->name?$chat->name:"--"}}</h1>
                                 <p class="desc">{{ $chat->message}}</p>
                              </span>
                              <p class="date">{{ Carbon\Carbon::parse($chat->created_at)->diffForHumans() }}</p>
                           </a>                    
                        </div>
                        @endforeach
                        @else
                        <h1 class="text-danger">No Data Found</h1> 
                        @endif
                     </div> 
                  </div>
               </div>
	</div>
</div>

@endsection

@section('additional-scripts')
<script>
    $(document).ready(function() {
      let id = "{{auth('admin')->id()}}";
      
      let role = 'admin';
      $(document).on('click', '#search', function(){
         keyword = $('#keyword').val();
         if (!keyword || keyword == '')
         {
            alert('Field can not empty');
            return;
         }
      $.ajax({
        url: "{{ route('admin_search_users') }}",
         data: {
            keyword,
            id,
            role
         },
         type: 'GET',
         dataType: 'json',
         success: function(result) {
            console.log(result)
            if (result)
            {
               $("#users_list").remove();
               var html = `<div id="users_list">`;
               if ( result.length > 0 )
               {
                  $.each(result, (key, value) => {
                     var url = '{{ route("county_chat", [":id" , ":role"]) }}';
                     url = url.replace(':id', value.id);
                     url = url.replace(':role', value.role);
                     html += `<a href="${url}"  >${value.name} </a> <br/> `;
                  });
                  
                  $('#keyword').val("");
               }else{
                  
                  html +=  `<p>Not Found</p>`;
               }
               html += `</div>`;

               
               $(html).insertAfter('#keyword')
            }

            }
         });
      });
      

    });
</script>
@endsection