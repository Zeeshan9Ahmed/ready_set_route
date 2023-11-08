@extends('dashboard.master')
@section('contents')

<div class="gen-sec">
   <div class="container type-2">
      <div class="searchRow">
         <form class="row" id="filter_form">

            <div class="col-4 form-group m-0">
               <select id="filter_1" name="filter_1">
                  <option selected value="">Please Select</option>
                  <option value="state">State</option>
                  <option value="county">County</option>
                  <option value="school">School</option>
               </select>
            </div>





         </form>
         <div class="col-4 form-group m-0">
            <select id="filter_type" name="filter_1" class="genInput11">
               <option selected value="">Please Select Filter Type</option>
               <option value="DAY">Daily</option>
               <option value="WEEK">Weekly</option>
               <option value="MONTH">Monthly</option>
            </select>
         </div>

         <div class="col-2 form-group m-0">
            <button class="genBtn" id="search">Filter</button>
         </div>

      </div>


      <div class="gentableWrap type-1 col-12">
         <h1 class="heading">Drivers

         </h1>
         <table class="display nowrap dataTable" id="drivers" style="width:100%">
            <thead class="thead-dark">
               <tr>

                  <th scope="col">Driver Name</th>
                  <th scope="col">Driver Email</th>
                  <th scope="col">Vehicle Model</th>
                  <th scope="col">Vehicle Mileage</th>
                  <th scope="col">Vin Number</th>
                  <th scope="col">Vehicle Number</th>
                  <th scope="col">Start Date</th>
                  <th scope="col">End Date</th>
                  <th scope="col">Total Distance</th>
                  <th scope="col">Distance Unit</th>
                  <th scope="col">Total Price</th>

                  {{-- <th scope="col">Details</th> --}}
               </tr>
            </thead>
            <tbody>
               
               </tbody>
            </table>
            <div class="col-xs-1 text-center" id="show">

               <h1>Filtered Data Will be shown here</h1>
            </div>
      </div>


   </div>
</div>


@endsection

@section('additional-scripts')
<script>
   $(document).ready(function() {

      var id;

      function ucwords(str) {
         return (str + '').replace(/^([a-z])|\s+([a-z])/g, function($1) {
            return $1.toUpperCase();
         });
      }

      // get_filtered_drivers
      $(document).on('click', '#search', function(e) {
         type = $("#filter_1").val();
         filter_type = $("#filter_type").val();
         type_id = id;
         // console.log(type, 'type', filter_type, 'filter_type', type_id, 'type_id')
         if (!type) {
            alert("Please Select County , School Or State")
            return;
         }
         if (!filter_type) {
            alert("Please Select Monthly , Weekly Or Daily")
            return;
         }
         $.ajax({

            url: "{{ route('get_filtered_drivers') }}",
            data: {
               type,
               filter_type,
               type_id
            },
            type: 'GET',
            dataType: 'json',
            success: function(result) {
               // console.log(result,'result')
               $("#drivers tbody").empty();
               data = result.data;
               console.log(data,'data')
               // return;
               if (data.length <= 0){
                  $("#show").html("<h1>No Record Found</h1>")
                  return;
               }
               tr = "";
               $.each(data, (key, value) => {
                  var url = "{{ route('school-admin-driver-vehicle', ':id') }}"
                  url = url.replace(':id', value?.id);
                  date = value.date.split("to")
                  start_date = date[0];
                  end_date = date[1];
                  tr += `<tr>
                           <td>${value?.name}</td>
                           <td>${value?.email}</td>
                           <td>${value?.vehicle_model??"----"}</td>
                           <td>${value?.vehicle_mileage??"----"}</td>
                           <td>${value?.vin_number??"----"}</td>
                           <td>${value?.vehicle_number??"----"}</td>
                           <td>${start_date}</td>
                           <td>${end_date}</td>
                           <td>${value?.total_distance==null?0:value.total_distance}</td>
                           <td>MILES</td>
                           <td>${value?.total_price==null?0:value.total_price}</td>
                           {{-- <td><a class="viewBtn" href="${url}">View</a></td> --}}
                        </tr>`;
               })
               $("#show").html("")
               $("#drivers tbody").append(tr)
              
            }
         });

      });
      $(document).on('change', '#filter_1', function(e) {
         type = this.value;
         if (!type){
            return;
         }
         // console.log(type)
         $.ajax({

            url: "{{ route('get_filter_type') }}",
            data: {
               type
            },
            type: 'GET',
            dataType: 'json',
            success: function(result) {
               var data = result.data
               $('#county,#state,#school').parent().remove()
               var div = `<div class="col-5 form-group m-0" >
               <select id="${type}" name="county_id">
                  <option selected>Please Select A ${ucwords(type)} </option>`;

               $.each(data, (key, value) => {
                  div += `<option value="${value.id}">${value.name}</option>`;
               })
               div += `</select></div>`
               $("#filter_form").append(div)
               return;
            }
         });

      });

      $(document).on('change', '#state,#county,#school', function(e) {
         type = $(this).attr('id')
         id = $(this).val();
         return;
      });
   });
</script>
@endsection