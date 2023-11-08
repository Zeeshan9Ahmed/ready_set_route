@extends('County.slicing.master')
@section('contents')
<div class="gen-sec">
	<div class="container type-2">
		<div class="row">
               <div class="gentableWrap type-1 col-8">
                  <h1 class="heading">Edit Teacher Details
                     <a href="#!" class="filter-1"><i class="fas fa-ellipsis-h"></i>
                        <span class="genDropdown">
                           <button>Edit</button>
                           <button>Remove</button>
                        </span>
                     </a>
                  </h1> 
                  <form class="upload-pkg-form push-msg row">
                     <div class=" col-12 form-group">
                        <div class="avatar-upload">
                           <div class="avatar-edit">
                              <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg">
                              <label for="imageUpload"><i class="fas fa-plus"></i></label>
                           </div>
                           <div class="avatar-preview">
                              <div id="imagePreview" style="background-image: url(assets/images/user-image.png);">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class=" col-12 form-group">
                        <label class="abs-icon"> 
                           <span>
                              <img src="assets/images/upload-icon.png" alt="img">
                              <p class="desc">Upload Card</p>
                           </span>
                           <input type="file" size="80" >
                        </label>
                     </div>
                     <div class=" col-12 form-group">
                        <input type="text" placeholder="Full Name">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="text" placeholder="Email">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="tel" placeholder="Phone">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="text" placeholder="County">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="text" placeholder="School">
                     </div>
                     <div class=" col-12 form-group">
                        <input type="text" placeholder="Address">
                     </div>
                     <div class=" col-12 form-group">
                        <input placeholder="Joining Date" class="textbox-n" type="text" onfocusin="(this.type='date')" onfocusout="(this.type='text')"  id="date">
                     </div>
                     <div class="col-12 form-group mt-3">
                        <button class="sendBtn">Save Changes</button>
                     </div>
                  </form>
               </div>
            </div>
	</div>
</div>

@endsection