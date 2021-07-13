@extends('admin.layouts')
@section('extra-css')
@endsection
@section('body-section')
<div class="content">
    <!-- BEGIN: Top Bar -->
    <div class="top-bar">
        <!-- BEGIN: Breadcrumb -->
        <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="" class="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Dashboard</a> </div>
        <!-- END: Breadcrumb -->
        @include('admin.header')
    </div>
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Push Notification
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button id="add_new" class="button text-white bg-theme-1 shadow-md mr-2">Add New Push Notification</button>
        </div>
    </div>
    <!-- BEGIN: Datatable -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">#</th>
                    <th class="border-b-2 whitespace-no-wrap">Title</th>
                    <th class="border-b-2 whitespace-no-wrap">Description</th>
                    <th class="border-b-2 whitespace-no-wrap">Send To</th>
                    <th class="border-b-2 whitespace-no-wrap">Date and Time</th>
                    <th class="border-b-2 whitespace-no-wrap">Expiry Date</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($push_notification as $key => $row)
                <tr>
                    <td class="text-center border-b">{{$key + 1}}</td>
                    <td><a>{{$row->title}}</a></td>
                    <td><a>{{$row->description}}</a></td>
                    <td class="w-40">
                        @if($row->send_to == 1)
                        <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> All Shop </div>
                        @elseif($row->send_to == 2)
                        <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> All Customer </div>
                        @elseif($row->send_to == 3)
                        <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Selected Shop </div>
                        @else
                        <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Selected Customer </div>
                        @endif
                    </td>
                    <td>{{$row->created_at}}</td>
                    <td>{{$row->expiry_date}}</td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                           
                            
                            @if($row->expiry_date != '')
                            @if($row->expiry_date >= date('Y-m-d'))
                                <a onclick="Edit({{$row->id}})" class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <a onclick="Delete({{$row->id}})" class="flex items-center justify-center text-theme-9" href="javascript:;"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                <!-- <a onclick="SendNotification({{$row->id}})" class="flex items-center justify-center text-theme-6" href="#"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Send</a> -->
                                @else
                                <a class="flex items-center mr-3" href="#">Expired</a>
                            @endif
                            @else
                                <a onclick="Edit({{$row->id}})" class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <a onclick="Delete({{$row->id}})" class="flex items-center justify-center text-theme-9" href="javascript:;"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                <!-- <a onclick="SendNotification({{$row->id}})" class="flex items-center justify-center text-theme-6" href="#"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Send</a> -->
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Datatable -->
</div>
<!-- END: Content -->


<!-- BEGIN: Header & Footer Modal -->
<div class="modal" id="popup_modal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 id="modal-title" class="font-medium text-base mr-auto">
                Add Push Notification
            </h2>
            <!-- <button class="button border items-center text-gray-700 hidden sm:flex"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs </button>
            <div class="dropdown relative sm:hidden">
                <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <i data-feather="more-horizontal" class="w-5 h-5 text-gray-700"></i> </a>
                <div class="dropdown-box mt-5 absolute w-40 top-0 right-0 z-20">
                    <div class="dropdown-box__content box p-2">
                        <a href="javascript:;" class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs </a>
                    </div>
                </div>
            </div> -->
        </div>
        <form class="validate-form" id="form" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id">
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12 sm:col-span-12">
                <label>Title</label>
                <input autocomplete="off" type="text" class="input w-full border mt-2 flex-1" name="title" id="title">
            </div>
            <div class="col-span-12 sm:col-span-12">
                <label>Description</label>
                <textarea class="input w-full border mt-2 flex-1" name="description" id="description"></textarea>
            </div>
            <div class="col-span-12 sm:col-span-12">
                <label>Category Type</label>
                <select onchange="usertype()" id="send_to" name="send_to" class="input w-full border mt-2 flex-1">
                    <option value="">SELECT</option>
                    <option value="1">All Shop</option>
                    <option value="2">All Customer</option>
                    <option value="3">Selected Shop</option>
                    <option value="4">Selected Customer</option>
                </select>
            </div>
            <div class="col-span-12 sm:col-span-12" id="customershow">
                <label>Select the Customer</label>
                <select id="customer_id" name="customer_id[]" class="select2 w-full" multiple>
                    @foreach ($customer as $customer1)
                        <option value="{{$customer1->id}}">{{$customer1->first_name}} {{$customer1->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-12 sm:col-span-12" id="shopshow">
                <label>Select the Shop</label>
                <select id="shop_id" name="shop_id[]" class="select2 w-full" multiple>
                    @foreach ($user as $user1)
                        @if($user1->busisness_name != '')
                        <option value="{{$user1->id}}">{{$user1->busisness_name}}</option>
                        @else
                        <option value="{{$user1->id}}">{{$user1->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-span-12 sm:col-span-12">
                <label>Expiry Date</label>
                <input autocomplete="off" type="date" class="input w-full border mt-2 flex-1" name="expiry_date" id="expiry_date">
            </div>
        </div>
        </form>
        <div class="px-5 py-3 text-right border-t border-gray-200">
            <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button>
            <button onclick="Save()" id="saveButton" type="button" class="button w-20 bg-theme-1 text-white">Save</button>
            <button onclick="Send()" id="saveButton" type="button" class="button w-20 bg-theme-1 text-white">Save & Send</button>
        </div>
    </div>
</div>
<!-- END: Header & Footer Modal -->
@endsection
@section('extra-js')
<script type="text/javascript">
$('.push_notification').addClass('side-menu--active');

$("#customershow").hide();
$("#shopshow").hide();

function usertype(){
  var send_to = $("#send_to").val();
  if(send_to == '1'){
    $("#shopshow").hide();
    $("#customershow").hide();
  }
  else if(send_to == '2'){
    $("#shopshow").hide();
    $("#customershow").hide();
  }
  else if(send_to == '3'){
    $("#shopshow").show();
    $("#customershow").hide();
  }
  else if(send_to == '4'){
    $("#shopshow").hide();
    $("#customershow").show();
  }
}

var action_type;
$('#add_new').click(function(){
    $('#popup_modal').modal('show');
    $("#form")[0].reset();
    $(".label-error").remove();
    $('.input').removeClass('error');
    action_type = 1;
    $('#saveButton').text('Save');
    $('#modal-title').text('Add Push Notification');
});

function Save(){
  $(".label-error").remove();
  $('.input').removeClass('error');
  var formData = new FormData($('#form')[0]);
  if(action_type == 1){
    $.ajax({
        url : '/admin/save-notification',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {                
            $("#form")[0].reset();
            $('#popup_modal').modal('hide');
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Save',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                $('.datatable-wrapper').load(location.href+' .datatable-wrapper');
            });
        },error: function (data) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
                //toastr.error(obj[0]);
                //alert(obj[0]);
                $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
                $('#'+i).addClass('error');
            });
        }
    });
  }else{
    $.ajax({
        url : '/admin/update-notification',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {                
            $("#form")[0].reset();
            $('#popup_modal').modal('hide');
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Update',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                $('.datatable-wrapper').load(location.href+' .datatable-wrapper');
            });
        },error: function (data) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
                $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
                $('#'+i).addClass('error');
            });
        }
    });
  }
}

function Send(){
  $(".label-error").remove();
  $('.input').removeClass('error');
  var formData = new FormData($('#form')[0]);
  if(action_type == 1){
    $.ajax({
        url : '/admin/save-send-notification',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {                
            $("#form")[0].reset();
            $('#popup_modal').modal('hide');
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Save',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                $('.datatable-wrapper').load(location.href+' .datatable-wrapper');
            });
        },error: function (data) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
                //toastr.error(obj[0]);
                //alert(obj[0]);
                $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
                $('#'+i).addClass('error');
            });
        }
    });
  }else{
    $.ajax({
        url : '/admin/update-send-notification',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {                
            $("#form")[0].reset();
            $('#popup_modal').modal('hide');
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Update',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                $('.datatable-wrapper').load(location.href+' .datatable-wrapper');
            });
        },error: function (data) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
                $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
                $('#'+i).addClass('error');
            });
        }
    });
  }
}

function Edit(id){
  $.ajax({
    url : '/admin/notification/'+id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        $('#modal-title').text('Update Notification');
        $('#save').text('Save Change');
        $('input[name=title]').val(data.title);
        $('input[name=expiry_date]').val(data.expiry_date);
        $('textarea[name=description]').val(data.description);
        $('select[name=send_to]').val(data.send_to);
        $('input[name=id]').val(id);
        if(data.send_to == '1'){
            $("#shopshow").hide();
            $("#customershow").hide();
        }
        else if(data.send_to == '2'){
            $("#shopshow").hide();
            $("#customershow").hide();
        }
        else if(data.send_to == '3'){
            $("#shopshow").show();
            $("#customershow").hide();
            get_notification_shop(data.id);
        }
        else if(data.send_to == '4'){
            $("#shopshow").hide();
            $("#customershow").show();
            get_notification_customer(data.id);
        }
        action_type = 2;
        $(".label-error").remove();
        $('.input').removeClass('error');
        $('#popup_modal').modal('show');
    }
  });
}

function Delete(id){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/admin/notification-delete/'+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //toastr.success(data, 'Successfully Delete');
            Swal.fire({
                //title: "Please Check Your Email",
                text: "Successfully Delete!",
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                $('.datatable-wrapper').load(location.href+' .datatable-wrapper');
            });
        }
      });
    } 
}


function get_notification_shop(id)
{
    $.ajax({        
        url : '/admin/get-notification-shop/'+id,
        type: "GET",
        success: function(data)
        {
           $('#shop_id').html(data);
        }
   });
}

function get_notification_customer(id)
{
    $.ajax({        
        url : '/admin/get-notification-customer/'+id,
        type: "GET",
        success: function(data)
        {
           $('#customer_id').html(data);
        }
   });
}

function SendNotification(id){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/admin/notification-send/'+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          Swal.fire({
                //title: "Please Check Your Email",
                text: "Successfully Send!",
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                $('.datatable-wrapper').load(location.href+' .datatable-wrapper');
            });
        }
      });
    } 
}
</script>
@endsection
            
        