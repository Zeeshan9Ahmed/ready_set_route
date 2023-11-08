@extends('School.slicing.master')
@section('contents')
<style>
   .driverBtn {
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
                    <a href="{{ route('createDriver') }}" class="driverBtn">
                    Create Driver
                    </a>

               </h1>
               <h1 class="heading">Send Invite

               </h1>

               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        <th scope="col">Driver Name</th>
                        <th scope="col">Driver Email</th>
                        <th scope="col">Invite</th>
                         </tr>
                  </thead>
                  <tbody>
                    @foreach ($drivers as $driver)
                     <tr>
                        <td>{{$driver->driver_name}}</td>
                        <td>{{$driver->email}}</td>
                        <td id="driver_id" data-id="{{$driver->id}}"><button type="button" class="btn btn-primary">Invite</button></td>
                    </tr>
                    @endforeach

                  </tbody>
               </table>
            </div>

	</div>
</div>

@endsection

@section('additional-scripts')
<script>
    $(document).ready(function() {
        console.log('working')
        // $('#driver_id[data-id]').click(function(){
        $(document).on('click', '#driver_id[data-id]',function(){
            let that = $(this);
            let driver_id = that.attr("data-id");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('school-admin-send-invite') }}",
                data: {
                    driver_id
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    if (result)
                    {
                    $(that).parent("tr:first").remove()

                        console.log(result)
                    }

                }
                });
            });





    });

</script>
@endsection
