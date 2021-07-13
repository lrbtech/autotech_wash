@extends('agent.layouts')
@section('extra-css')
@endsection
@section('body-section')
<!-- BEGIN: Content -->
<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Service
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button id="add_new" class="button text-white bg-theme-1 shadow-md mr-2">Add New Service</button>
            <!-- <div class="dropdown relative ml-auto sm:ml-0">
                <button class="dropdown-toggle button px-2 box text-gray-700">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                </button>
                <div class="dropdown-box mt-10 absolute w-40 top-0 right-0 z-20">
                    <div class="dropdown-box__content box p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-plus" class="w-4 h-4 mr-2"></i> New Category </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="users" class="w-4 h-4 mr-2"></i> New Group </a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <!-- BEGIN: Datatable -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">#</th>
                    <th class="border-b-2 whitespace-no-wrap">Service Name</th>
                    <th class="border-b-2 whitespace-no-wrap">Price</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Status</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shop_service as $key => $row)
                <tr>
                    <td class="text-center border-b">{{$key + 1}}</td>
                    <td>
                        @foreach($service as $ser)
                            @if($ser->id == $row->service_id)
                            {{$ser->service_name_english}}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        {{$row->price}}
                    </td>
                    <td class="w-40">
                        @if($row->status == 0)
                        <div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Active </div>
                        @else 
                        <div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Inactive </div>
                        @endif
                    </td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a onclick="Edit({{$row->id}})" class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                            @if($row->status == 1)
                            <a onclick="Delete({{$row->id}},0)" class="flex items-center justify-center text-theme-9" href="javascript:;"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Active </a>
                            @else 
                            <a onclick="Delete({{$row->id}},1)" class="flex items-center justify-center text-theme-6" href="javascript:;"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> InActive </a>
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
                Add Service
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
                <label>Choose Service</label>
                <select class="input w-full border mt-2 flex-1" name="service_id" id="service_id">
                    <option value="">SELECT</option>
                    @foreach($service as $row)
                    <option value="{{$row->id}}">{{$row->service_name_english}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-12 sm:col-span-12">
                <label>Price</label>
                <input autocomplete="off" type="text" class="input w-full border mt-2 flex-1" name="price" id="price">
            </div>
            <!-- <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="text-center border-b-2 whitespace-no-wrap">Vehicle Type</th>
                            <th class="text-center border-b-2 whitespace-no-wrap">Price</th>
                        </tr>
                    </thead>
                    <tbody id="view_price">
                    @foreach($vehicle_type as $key => $row)
                    <tr>
                        <td class="text-center border-b">
                            {{$row->vehicle_type}}
                            <input value="{{$row->id}}" type="hidden" name="type_id[]">
                        </td>
                        <td class="text-center border-b">
                            <div class="col-span-12 sm:col-span-12">
                                <input autocomplete="off" type="text" class="input w-full border mt-2 flex-1" name="price[]">
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> -->
        </div>
        </form>
        <div class="px-5 py-3 text-right border-t border-gray-200">
            <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button>
            <button onclick="Save()" id="saveButton" type="button" class="button w-20 bg-theme-1 text-white">Save</button>
        </div>
    </div>
</div>
<!-- END: Header & Footer Modal -->
@endsection
@section('extra-js')
<script type="text/javascript">
$('.menu-service').addClass('top-menu--active');
//$('.service').addClass('top-menu--active');

var action_type;
$('#add_new').click(function(){
    $('#popup_modal').modal('show');
    $("#form")[0].reset();
    $('input[name="price[]"]').val('');
    action_type = 1;
    $(".label-error").remove();
    $('.input').removeClass('error');
    $('#saveButton').text('Save');
    $('#modal-title').text('Add Service');
});

function Save(){
  $(".label-error").remove();
  $('.input').removeClass('error');
  var formData = new FormData($('#form')[0]);
  if(action_type == 1){
    $.ajax({
        url : '/agent/save-service',
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
                $("#"+i).after('<label class="label-error error" for="'+i+'">'+obj[0]+'</label>');
                $('#'+i).addClass('error');
            });
        }
    });
  }else{
    $.ajax({
        url : '/agent/update-service',
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
    url : '/agent/edit-service/'+id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      $('#modal-title').text('Update Service');
      $('#save').text('Save Change');
      $('select[name=service_id]').val(data.service_id);
      $('input[name=price]').val(data.price);
      $('input[name=id]').val(id);
      action_type = 2;
      $(".label-error").remove();
      $('.input').removeClass('error');
      //get_service_price(id);
      $('#popup_modal').modal('show');
    }
  });
}

function get_service_price(id)
{
    $.ajax({        
        url : '/agent/get-service-price/'+id,
        type: "GET",
        success: function(data)
        {
           $('#view_price').html(data);
        }
   });
}

function Delete(id,status){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/agent/delete-service/'+id+'/'+status,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {          
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Delete',
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
            
        