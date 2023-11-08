$(document).ready(function(){
  $('#examp').dataTable({
    ordering: false,
    paging: false,
    responsive: true,
    
    fixedHeader: {
      header: true
    },
    dom: 'Bfrtip',
    buttons: [
    {
      extend: 'excel',
      text: 'Excel <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>'
    },
    {
      extend: 'pdf',
      text: 'PDF <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>'
    }, 
    'copy',
    'pdf',
    'colvis'
    ],
    
  });
});


$(document).ready(function(){
  $('#reff').dataTable({
    paging: false,
    responsive: true,
    fixedHeader: {
      header: true
    },
    dom: 'Bfrtip',
    buttons: [
    {
      extend: 'excel',
      text: 'Excel <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>'
    },
    {
      extend: 'pdf',
      text: 'PDF <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>'
    },
    
    'copy',
    'pdf',
    'colvis'
    ],
    
  });
});

$(document).ready(function(){
  $('.payment-type').click(function(){
    $('#payment-modal').hide();
    $('.modal-backdrop').hide();
        //$('#credit-modal').show();
      });
});
// Avtar JS
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#imagePreview').css('background-image', 'url('+e.target.result +')');
      $('#imagePreview').hide();
      $('#imagePreview').fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#imageUpload").change(function() {
  readURL(this);
});



// AUTO COMPLETE SEARCH
$(function () {
  // prevent the list from opening by clicking on an empty field
  $(".dropdown").on("show.bs.dropdown", function (e) {
    if (!e.relatedTarget.value) {
      return false;
    }
  });

  // handle changes in the input field
  $("#exampleFormControlInput1").on("input", function (e) {
    if (this.value) {
      $(this).dropdown("show");
    } else {
      $(this).dropdown("hide");
    }
  });
});


// ONLOAD ANIMATION
window.addEventListener('load', () => {
  var fadeTarget = document.getElementById("loading");
  var fadeEffect = setTimeout(function () {
    fadeTarget.style.opacity = "0";
    fadeTarget.style.zIndex = "-9999";
  }, 100);
});




$(document).ready(function(){

  $(".dropdownBtn").click(function() {
   $(".dropdownList").slideToggle();
  });


  $("#dropdownNav").click(function() {
    $(".dropdownList-2").slideToggle();
  });


  $("#searchBtn").click(function() {
    $(".searchBox").toggleClass("active");
  });

  $(".searchBox .closeBtn").click(function() {
    $(".searchBox").removeClass("active");
  });



  $("#studentForm").click(function(){
    $("#student").addClass("active");
  });

  $(".otherForm").click(function(){
    $("#student").removeClass("active");
  });


  // $(".sideToggle").click(function(){
  //   $("aside").toggleClass("active");
  // });


  $(".toogle-close-btn").click(function(){
    $("aside").removeClass("active");
  });

  $(".viewBtn").click(function (e) {
   $(this).addClass("active");
   $(this).removeClass("active");
 });

  $(".detailBody .detailContent .genBtn").click(function (e) {
   $(this).addClass("active");
   $(this).removeClass("active");
  });


  $(".indicator").click(function (e) {
   $(this).addClass("active");
   $(this).removeClass("active");
 });


  $(".list-toggle").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
  });


  $(".filter-1").click(function(e){ 
    e.preventDefault();
    $(this).find(".genDropdown").toggleClass("active");  
    e.stopPropagation() 
  });
  $(".genDropdown").click(function(e){
    e.stopPropagation();
  });

});



