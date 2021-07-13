@extends('agent.layouts')
@section('extra-css')
@endsection
@section('body-section')
<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Add Coupon
    </h2>
    <form class="validate-form" id="coupon_form" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" value="{{ Request::segment(3) }}" name="id" id="id">
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div>
                    <label>Coupon Code</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Enter your coupon code" name="coupon_code" id="coupon_code">
                </div>
                <div class="mt-3">
                    <label>Description</label>
                    <div class="mt-2">
                        <!-- <textarea data-feature="basic" class="summernote" name="description" id="description"></textarea> -->
                        <textarea class="input w-full border mt-2" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>Start Date</label>
                          <input type="date" class="input w-full border mt-2" name="start_date" id="start_date">
                        </div>
                        <div class="relative mt-2">
                          <label>End Date</label>
                          <input type="date" class="input w-full border mt-2" name="end_date" id="end_date">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>Discount type</label>
                          <select onchange="discounttype()" id="discount_type" name="discount_type" class="input w-full border mt-2">
                            <!-- <option value="1">Discount from service</option>
                            <option value="2">% Discount from service</option> -->
                            <option value="3">Discount Value</option>
                            <option value="4">% Discount Percentage</option>
                          </select>
                        </div>
                        <div class="relative mt-2">
                          <label id="per">Amount</label>
                          <input type="text" id="amount" name="amount" class="input w-full border mt-2" placeholder="Enter the discount Amount">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>Usage minimum order value</label>
                          <input type="text" class="input w-full border mt-2" name="minimum_order_value" id="minimum_order_value">
                        </div>
                        <div class="relative mt-2">
                          <label>Usage limit per user</label>
                          <input type="text" class="input w-full border mt-2" name="limit_per_user" id="limit_per_user">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="sm:grid grid-cols-2 gap-6">
                        <div class="relative mt-2">
                          <label>User Type</label>
                          <select onchange="usertype()" id="user_type" name="user_type" class="input w-full border mt-2">
                            <option value="">All</option>
                            <option value="1">Selected User</option>
                          </select>
                        </div>
                        <div id="usershow" class="relative mt-2">
                          <label>Select the User</label>
                          <select id="user_id" name="user_id[]" class="select2 w-full" multiple>
                            <option value="">Select</option>
                            @foreach ($user as $user1)
                            <option value="{{$user1->id}}">{{$user1->mobile}} - {{$user1->first_name}} {{$user1->last_name}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="button" class="button w-24 border text-gray-700 mr-1">Cancel</button>
                    <button onclick="Save()" type="button" class="button w-24 bg-theme-1 text-white">Save</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
    </form>
</div>
<!-- END: Content -->

@endsection
@section('extra-js')
<script type="text/javascript">
$('.coupon').addClass('top-menu--active');

$(".select2").select2({
    dropdownAutoWidth: true,
    width: '100%'
});
$("#serviceshow").hide();
$("#usershow").hide();
function discounttype(){
  var discount_type = $("#discount_type").val();
  // if(discount_type == "1" || discount_type == "2"){
  //   $("#serviceshow").show();
  //   $('input[name=service_id]').val('');
  // }
  // else{
  //   $("#serviceshow").hide();
  // }
  if(discount_type == '2' || discount_type == "4"){
    $("#maxshow").show();
    $('#per').html("Percentage");
  }
  else{
    $("#maxshow").hide();
    $('#per').html("Amount");
  }
}
function usertype(){
  var user_type = $("#user_type").val();
  if(user_type == '1'){
    $("#usershow").show();
  }
  else{
    $("#usershow").hide();
  }
}
  var id = $("#id").val();
  $.ajax({
        url : '/agent/edit-coupon/'+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('input[name=coupon_code]').val(data.coupon_code);
          $('textarea[name=description]').val(data.description);
          $('input[name=start_date]').val(data.start_date);
          $('input[name=end_date]').val(data.end_date);
          $('select[name=discount_type]').val(data.discount_type);
          $('select[name=user_type]').val(data.user_type);
          $('input[name=amount]').val(data.amount);
          //$('input[name=max_value]').val(data.max_value);
          $('input[name=limit_per_user]').val(data.limit_per_user);
          $('input[name=minimum_order_value]').val(data.minimum_order_value);
          $('input[name=id]').val(data.id);
  // if(data.discount_type == 1 || data.discount_type == 2){
  //   $("#serviceshow").show();
  //   get_coupon_service(data.id);
  // }
  // else{
  //   $("#serviceshow").hide();
  // }
  if(data.discount_type == 2 || data.discount_type == 4){
    $("#maxshow").show();
    $('#per').html("Percentage");
  }
  else{
    $("#maxshow").hide();
    $('#per').html("Amount");
  }
  if(data.user_type == 1){
    $("#usershow").show();
    get_coupon_user(data.id);
  }
  else{
    $("#usershow").hide();
  }
          //$('#user_model').modal('show');
          action_type = 2;
        }
      });
function get_coupon_service(id)
{
    $.ajax({        
        url : '/agent/get_coupon_service/'+id,
        type: "GET",
        success: function(data)
        {
           $('#service_id').html(data);
        }
   });
}
function get_coupon_user(id)
{
    $.ajax({        
        url : '/agent/get_coupon_user/'+id,
        type: "GET",
        success: function(data)
        {
           $('#user_id').html(data);
        }
   });
}
if(id==""){
    function Save(){
      $(".label-error").remove();
      $('.input').removeClass('error');
      var formData = new FormData($('#coupon_form')[0]);
      $.ajax({
          url : '/agent/coupon-save',
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "JSON",
          success: function(data)
          {
            console.log(data);                
            $("#coupon_form")[0].reset();
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Save',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
              window.location.href="/agent/coupon/";
            });
          },
          error: function (data, errorThrown) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
              $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
              $('#'+i).addClass('error');
            });
          }
      });
    }
}
else{
    function Save(){
      $(".label-error").remove();
      $('.input').removeClass('error');
      //alert($("#service_id").val());
      var formData = new FormData($('#coupon_form')[0]);
      $.ajax({
          url : '/agent/coupon-update',
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "JSON",
          success: function(data)
          {
            console.log(data);                
            $("#coupon_form")[0].reset();
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Update',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
              window.location.href="/agent/coupon/";
            });
          },
          error: function (data, errorThrown) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
              $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
              $('#'+i).addClass('error');
            });
          }
      });
    }
}
</script>
@endsection
            
        