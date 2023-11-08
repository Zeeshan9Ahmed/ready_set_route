@extends('dashboard.master')
@section('contents')

<div class="gen-sec">
	<div class="container type-2">
		<div class="gentableWrap type-1 col-10">
               <h1 class="heading">Financials
                  <a href="#!" class="filter-1"><i class="fas fa-ellipsis-h"></i>
                     <span class="genDropdown">
                        <button>Edit</button>
                        <button>Remove</button>
                     </span>
                  </a>
               </h1>  
               <table class="display nowrap dataTable" id="examp" style="width:100%">
                  <thead class="thead-dark">
                     <tr>
                        <th scope="col">
                           <form action="">
                              <input type="checkbox" class="list-toggle">
                           </form>
                        </th>
                        <th scope="col">County Name</th>
                        <th scope="col">Package</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Subscribe Date</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Download</th> 
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Startup</td>
                        <td>$99</td>
                        <td class="color-1">Active</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Business Plan</td>
                        <td>$99</td>
                        <td class="color-2">Inactive</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Enterprise</td>
                        <td>$99</td>
                        <td class="color-1">Active</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Business Plan</td>
                        <td>$180</td>
                        <td class="color-1">Active</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Enterprise</td>
                        <td>$90</td>
                        <td class="color-1">Active</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Business Plan</td>
                        <td>$89</td>
                        <td class="color-2">Inactive</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Startup</td>
                        <td>$99</td>
                        <td class="color-2">Inactive</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Enterprise</td>
                        <td>$499</td>
                        <td class="color-1">Active</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                     <tr>
                        <td>
                           <form action="">
                              <input type="checkbox" class="list-sort">
                           </form>
                        </td>
                        <td>County 01</td>
                        <td>Business Plan</td>
                        <td>$299</td>
                        <td class="color-1">Active</td>
                        <td>15 Nov, 2021</td>
                        <td>15 Nov, 2022</td>
                        <td><a href="#!" class="viewBtn">Download</a></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="col-10 p-0">
               <div class="searchRow justify-content-end">
                  <button class="genBtn">Download All</button>
               </div>
            </div>s
	</div>
</div>


@endsection