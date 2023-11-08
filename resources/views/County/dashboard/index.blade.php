@extends('County.slicing.master')

@section('contents')

<div class="index-sec-1">
	<div class="container type-2">
		<div class="boxesWrap row">
			<div class="detailBox col-2">
				<p class="text">Schools <span>@if ( $dashboard_data  )   {{ $dashboard_data['total_schools'] }} @else 0 @endif</span></p>
				<div class="iconBox">
					<img src="{{ asset('public/admin/assets/images/d-box-img-2.png') }}" alt="img">
				</div>  
			</div>
			<div class="detailBox col-2">
				<p class="text">Teachers <span>@if ( $dashboard_data  )   {{ $dashboard_data['total_teachers'] }} @else 0 @endif</span></p>
				<div class="iconBox">
					<img src="{{ asset('public/admin/assets/images/d-box-img-3.png') }}" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Parents <span>@if ( $dashboard_data  )   {{ $dashboard_data['total_parents'] }} @else 0 @endif</span></p>
				<div class="iconBox">
					<img src="{{ asset('public/admin/assets/images/d-box-img-4.png') }}" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Students <span>@if ( $dashboard_data  )   {{ $dashboard_data['total_students'] }} @else 0 @endif</span></p>
				<div class="iconBox">
					<img src="{{ asset('public/admin/assets/images/d-box-img-5.png') }}" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Drivers <span>@if ( $dashboard_data  )   {{ $dashboard_data['total_drivers'] }} @else 0 @endif</span></p>
				<div class="iconBox">
					<img src="{{ asset('public/admin/assets/images/d-box-img-6.png') }}" alt="img">
				</div>  
			</div> 
		</div>
		<!-- <div class="boxesWrap row">
			<div class="detailBox col-2">
				<p class="text">States<span>12</span></p>
				<div class="iconBox">
					<img src="assets/images/d-box-img-7.png" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Counties<span>45</span></p>
				<div class="iconBox">
					<img src="assets/images/d-box-img-1.png" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">School <span>20</span></p>
				<div class="iconBox">
					<img src="assets/images/d-box-img-2.png" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Teachers <span>200</span></p>
				<div class="iconBox">
					<img src="assets/images/d-box-img-3.png" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Parents <span>350</span></p>
				<div class="iconBox">
					<img src="assets/images/d-box-img-4.png" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Students <span>350</span></p>
				<div class="iconBox">
					<img src="assets/images/d-box-img-5.png" alt="img">
				</div>  
			</div> 
			<div class="detailBox col-2">
				<p class="text">Drivers <span>175</span></p>
				<div class="iconBox">
					<img src="assets/images/d-box-img-6.png" alt="img">
				</div>  
			</div> 
		</div> -->


		<div class="row mapWrap">
			<div class="col-8">
				<div class="searchRow">
					<form class="row">
						<div class="col-3 form-group m-0">
							<select id="school" name="school_id">
								@if (count($schools) > 0)
								<option selected>Select School</option>
								@foreach ( $schools as $school)
								<option value="{{$school->id}}">{{$school->school_name}}</option>
								@endforeach
								@else
								<option selected>No Schools</option>
								@endif                             
							</select>
						</div>
						<div class="col-3 form-group m-0">
							<select id="driver" name="driver_id">
								<option selected>Select Driver</option>
								
							</select>
						</div>
						<div class="col-3 form-group m-0">
							<select id="students" name="student_id">
								<option selected>Select Student</option>
								                             
							</select>
						</div>

						{{-- 
							<div class="col-3 form-group m-0">
							<button class="genBtn">Locate</button>
						</div>
							
							--}}
					</form>
				</div>

				<div class="responsive-map">

				<iframe id="iframe" src="https://maps.google.com/maps?q=24.8607, 67.0011&z=15&output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>

			{{-- 
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
			
				
				--}}	
				</div>

				



			</div>
			<div class="col-4">
				<a class="genBtn type-2" href="{{ url('sub-admin-county/invite') }}">Invite</a>
				<div class="rightDetails">
					<div class="topHeader">
						<button class="dropdownBtn">Schools</button>
						<ul class="dropdownList" id="dropdownList">
							@if ( count($schools) > 0)
							@foreach ($schools as $school)
							<li id="{{$school->id}}"><a href="#!">{{ $school->school_name }}</a></li>
							@endforeach
							@endif
						</ul>
					</div>

					<ul class="action-btns">
                        <li class="actionBtn">
                            <a href="#!" class="actionLink">Teachers</a>
                            <p class="desc"><span id="teacher_count">0</span> No. of Teachers in this School.</p>
                        </li>
                        <li class="actionBtn">
                            <a href="#!" class="actionLink">Parents</a>
                            <p class="desc"><span id="parent_count">0</span> No. of Parents in this School.</p>
                        </li>
                        <li class="actionBtn">
                            <a href="#!" class="actionLink">Students</a>
                            <p class="desc"><span id="student_count">0</span> No. of Students in this School.</p>
                        </li>
                        <li class="actionBtn">
                            <a href="#!" class="actionLink">Drivers</a>
                            <p class="desc"><span id="driver_count">0</span> No. of Drivers in this School.</p>
                        </li>
                    </ul>                
				</div>               
			</div>
		</div>
	</div>
</div>



@endsection

@section('additional-scripts')
<script>
    $(document).ready(function() {
		let students = [];

		$(document).on('change', '#students', function (e){
			var student_id = this.value;
			address  = students.filter(function(index){
				return index.id == student_id;
			})[0];
			
			var newUrl = `https://maps.google.com/maps?q=${address.latitude}, ${address.longitude}&z=15&output=embed`;
			
			var iframe = $("#iframe").attr('src', newUrl);
			
		});


        $("#dropdownList li").click(function() {
            
            $("#dropdownList").hide();
            let school_id = $(this).attr('id');
			 

            $.ajax({

                url: "{{ route('county-school-data-count') }}",
                data: {
                    school_id: school_id
                },
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (result)
                    {
                        // console.log(result.school_count)
                        $('#teacher_count').html(result.teacher_count)
                        $('#parent_count').html(result.parent_count)
                        $('#student_count').html(result.student_count)
                        $('#driver_count').html(result.driver_count)
                    }

                }
            });
        });


		
		$(document).on('change', '#school', function (e){
            var school_id = this.value;
			
            $.ajax({
                url: "{{ route('county-school-drivers') }}",
                data: {
                    school_id: school_id
                },
                type: 'GET',
                dataType: 'json',
                success: function(result) {
					
                    $('select[name="driver_id"]').empty();
                    if (result.length > 0) {
                        $('select[name="driver_id"]').append('<option value="">' +
                            "Select Driver	" + '</option>');
                        $.each(result, (key, value) => {

                            $('select[name="driver_id"]').append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        })
                    } else {
                        $('select[name="driver_id"]').append('<option value="">' +
                            "No Driver Found" + '</option>');
                    }

                }
            });


        });

		$(document).on('change', '#driver', function (e){
            var driver_id = this.value;
			var school_id = $('#school').find(":selected").val();

            $.ajax({
                url: "{{ route('county-drivers-students') }}",
                data: {
                    driver_id: driver_id,
					school_id: school_id
                },
                type: 'GET',
                dataType: 'json',
                success: function(result) {
                    students = result;
                    $('select[name="student_id"]').empty();
                    if (result.length > 0) {
                        $('select[name="student_id"]').append('<option value="">' +
                            "Select Student	" + '</option>');
                        $.each(result, (key, value) => {

                            $('select[name="student_id"]').append('<option value="' +
                                value.id + '">' + value.student_name + '</option>');
                        })
                    } else {
                        $('select[name="student_id"]').append('<option value="">' +
                            "No Student Found" + '</option>');
                    }

                }
            });


        });


    });
</script>
@endsection