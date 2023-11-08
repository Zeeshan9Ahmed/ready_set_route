@extends('dashboard.master')
@section('contents')
<div class="gen-sec reports-tab">
	<div class="container type-2">
		<div class="searchRow">
               <form class="row">
                  <div class="col-3 form-group m-0">
                     <input type="search" placeholder="Search County">
                  </div>
                  <div class="col-3 form-group m-0">
                     <input type="text" placeholder="Year">
                  </div>
                  <div class="col-2 form-group m-0">
                     <button class="genBtn">Search</button>
                  </div>
               </form>
               <button class="genBtn">Download All</button>
            </div>
            <h1 class="reprt-top-heading pb-2">Lorem Ipsum School</h1>
            <div class="otherInfo">   
               <div class="otherDetail">
                  <p class="desc">County: County 1</p>
                  <p class="desc">Address: New York</p>
                  <p class="desc">No. of Students: 80</p>
               </div>
               <button class="genBtn">Download</button>
            </div>
            <div class="reportsTable">
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        <th scope="col">Student Name</th>
                        <th scope="col">January</th>
                        <th scope="col">February</th>
                        <th scope="col">March</th>
                        <th scope="col">April</th>
                        <th scope="col">May</th>
                        <th scope="col">June</th>
                        <th scope="col">July</th>
                        <th scope="col">August</th>
                        <th scope="col">September</th>
                        <th scope="col">October</th>
                        <th scope="col">November</th>
                        <th scope="col">December</th>
                        <th scope="col">Overall</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>Michael David</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                     </tr>
                     <tr>
                        <td>Sarah Williams</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                     </tr>
                     <tr>
                        <td>Charles Parker</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                     </tr>
                     <tr>
                        <td>Bryan Cooper</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                     </tr>
                     <tr>
                        <td>Sharon Doe</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                     </tr>
                     <tr>
                        <td>Susan</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                     </tr>
                     <tr>
                        <td>Jessica Morgan</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                     </tr>
                     <tr>
                        <td>Robert John</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                     </tr> 
                  </tbody>
               </table>
            </div>


            <h1 class="reprt-top-heading pb-2">Lorem Ipsum School</h1>
            <div class="otherInfo">   
               <div class="otherDetail">
                  <p class="desc">County: County 1</p>
                  <p class="desc">Address: New York</p>
                  <p class="desc">No. of Students: 80</p>
               </div>
               <button class="genBtn">Download</button>
            </div>
            <div class="reportsTable">
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        <th scope="col">Student Name</th>
                        <th scope="col">January</th>
                        <th scope="col">February</th>
                        <th scope="col">March</th>
                        <th scope="col">April</th>
                        <th scope="col">May</th>
                        <th scope="col">June</th>
                        <th scope="col">July</th>
                        <th scope="col">August</th>
                        <th scope="col">September</th>
                        <th scope="col">October</th>
                        <th scope="col">November</th>
                        <th scope="col">December</th>
                        <th scope="col">Overall</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>Michael David</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                        <td>89%</td>
                     </tr>
                     <tr>
                        <td>Sarah Williams</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                        <td>90%</td>
                     </tr>
                     <tr>
                        <td>Charles Parker</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                        <td>75%</td>
                     </tr>
                     <tr>
                        <td>Bryan Cooper</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                        <td>65%</td>
                     </tr>
                     <tr>
                        <td>Sharon Doe</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                        <td>79%</td>
                     </tr>
                     <tr>
                        <td>Susan</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                        <td>98%</td>
                     </tr>
                     <tr>
                        <td>Jessica Morgan</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                        <td>71%</td>
                     </tr>
                     <tr>
                        <td>Robert John</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                        <td>85%</td>
                     </tr> 
                  </tbody>
               </table>
            </div>
	</div>
</div>


@endsection