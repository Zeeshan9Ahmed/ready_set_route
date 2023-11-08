@extends('dashboard.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		 <div class="row">

         @if(session()->has('success'))
            <div class="alert alert-success col-8">
                {{ session()->get('success') }}
            </div>
        @endif
               <div class="gentableWrap type-1 col-8">
                  <h1 class="heading">Edit Package
                    
                  </h1> 
                  <form class="upload-pkg-form push-msg row" id="form" method="POST" action="{{ url('admin/edit-package') }}">
                    @csrf
                    <div class="card-body append">


                    <input type="hidden" name="plan_id" placeholder="Title" value="{{$plan->id}}">
                    
                    <div class="col-12 form-group">
                        <input type="name" name="title" placeholder="Title" value="{{$plan->title}}">
                     </div>
                     <div class="col-12 form-group">
                        <input type="text" name="description" placeholder="Description" value="{{$plan->description}}">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="number" name="price" placeholder="Price ($)" value="{{$plan->price}}">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="number" name="off" placeholder="Discount" value="{{$plan->off}}">
                     </div>
                     <div class=" col-12 form-group">
                        <select name="type">
                           {{-- 
                            <option disabled selected>Period</option>
                            --}}
                           
                           <option value="monthly" <?php if($plan->type == "monthly"){ echo "selected";}?>>Monthly</option>
                           
                           <option value="yearly" <?php if($plan->type == "yearly"){ echo "selected";}?>>Yearly</option>
                           
                        </select>
                     </div>
                     @foreach( $plan->features as $key => $feature)
                     <div class="col-12 form-group">
                         <input type="text" name="feature[]" value="{{$feature->feature}}" placeholder="Listing Features">
                         <input type="hidden" value="{{$feature->id}}" name="feature_id[]" >
                        @if ($key == "0")
                        <button class="addFeatureBtn" id="add-new" type="button"><i class="fas fa-plus"></i></button>
                        @else
                        <button class="addFeatureBtn" id="delete-feature" data-id="{{$feature->id}}" type="button"><i class="fa fa-times"></i> </i></button>
                        @endif
                     </div>
                     @endforeach


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

        $(document).on('click', '#delete-feature' , function()
        {
            let feature_id = $(this).attr('data-id')

            let that = $(this);
            if(! confirm("Are You Sure.?")){
                return;
            };
            if (!feature_id)
            {
                $(this).parent().remove();
                return;
            }

            $.ajax({
                url: "{{ route('delete-package-feature') }}",
                data: {
                    feature_id
                },
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result.status == 0 )
                    {
                        alert(result.message)
                        return;
                    }
                    $(that).parent().remove();
                    console.log(result)    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                   
                }
            });
            // console.log(feature_id) 
        })
    });

</script>
@endsection