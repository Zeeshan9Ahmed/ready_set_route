@extends('dashboard.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		 <div class="row">
               <div class="gentableWrap type-1 col-8">
                  <h1 class="heading">Upload Packages
                    
                  </h1> 
                  <form class="upload-pkg-form push-msg row" id="form" method="POST" action="{{ url('admin/save-package') }}">
                    @csrf
                    <div class="card-body append">


                    
                    <div class="col-12 form-group">
                        <input type="name" name="title" placeholder="Title">
                     </div>
                     <div class="col-12 form-group">
                        <input type="text" name="description" placeholder="Description">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="number" name="price" placeholder="Price ($)">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="number" name="off" placeholder="Discount">
                     </div>
                     <div class=" col-12 form-group">
                        <select name="type" required>
                           <option value="monthly">Monthly</option>
                           <option value="yearly">Yearly</option>
                        </select>
                     </div>
                     <div class="col-12 form-group">
                        <input type="text" name="feature[]" placeholder="Listing Features">
                        <button class="addFeatureBtn" id="add-new" type="button"><i class="fas fa-plus"></i></button>
                     </div>


                    </div>

                    


            {{-- 
                    <div class="col-12 form-group">
                        <input type="text" name="feature[]" placeholder="Listing Features">
                        <button class="addFeatureBtn" id="add-new" type="button"><i class="fas fa-plus"></i></button>
                     </div>
                     <div class="col-12 form-group">
                        <input type="text" name="feature[]" placeholder="Listing Features">
                        <button class="addFeatureBtn" id="add-new" type="button"><i class="fas fa-plus"></i></button>
                     </div>
            --}}
                     <div class="col-12 form-group mt-3">
                        <button class="sendBtn">Done</button>
                     </div>
                  </form>

               </div>
            </div>
	</div>
</div>

@endsection

@section('additional-scripts')
<script>

    $(document).ready(function(){
        $(document).on('click', '#add-new' , function(){
            let feature = `<div class="col-12 form-group">
                        <input type="text" name="feature[]" placeholder="Listing Features">
                        <button class="addFeatureBtn" id="delete-feature" type="button"><i class="fa fa-times"></i> </i></button>
                     </div>`;

            $(".append").append(feature);
            
        })

        $(document).on('click', '#delete-feature' , function(){
            if(! confirm("Are You Sure.?")){
                return;
            };
            $(this).parent().remove(); 
        })
    });

</script>
@endsection