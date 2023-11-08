@extends('School.slicing.master')
@section('contents')


<div class="gen-sec">
   <div class="container type-2">
      <div class="row">

         @if(session()->has('success'))
         <div class="alert alert-success">
            {{ session()->get('success') }}
         </div>
         @endif

         <div class="gentableWrap type-1 col-8">
            <h1 class="heading">Create Driver

            </h1>

            <form class="upload-pkg-form push-msg row" method="post" action="{{ route('save-driver') }}">
               @csrf
               <div class=" col-12 form-group">
                  <input type="name" name="name" placeholder="Driver Name" required>
               </div>
               <div class=" col-12 form-group">
                  @if($errors->any())
                  <span style="color: #431500 ;" class="text-danger">{{$errors->first()}}</span>
                  @endif
                  <input type="email" name="email" placeholder="Email" required>
               </div>
               <div class=" col-12 form-group">
                  <input type="password" name="password" placeholder="Password" required>
               </div>

               <div class=" col-12 form-group">
                  <input type="text" name="phone" id="phone" placeholder="phone" minlength="17" maxlength="17" value="+1 " required>
               </div>
               <div class="col-12 form-group mt-3">
                  <button class="sendBtn">Submit</button>
               </div>


            </form>

         </div>
      </div>
   </div>
</div>



@endsection

@section('additional-scripts')
<script>
   $(document).ready(function() {

      $(document).on('keydown', function(e) {
         if (e.keyCode == 8 && $('#phone').is(":focus") && $('#phone').val().length < 4) {
            e.preventDefault();
         }
      });
      $("#phone").keypress(function(e) {

         if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
         }

         var curchr = this.value.length;
         var curval = $(this).val();
         if (curchr == 6 && curval.indexOf("(") <= -1) {
            $(this).val("+1 (" + curval.replace("+1 ", "") + ")" + "-");
         } else if (curchr == 6 && curval.indexOf("(") > -1) {
            $(this).val(curval + ")-");
         } else if (curchr == 12 && curval.indexOf(")") > -1) {
            $(this).val(curval + "-");
         } else if (curchr == 9) {
            $(this).val(curval + "-");
            $(this).attr('maxlength', '14');
         }


      });



   });
</script>
@endsection