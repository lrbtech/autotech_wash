@extends('admin.layouts')
@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
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
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Profile Layout
        </h2>
    </div>
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img class="rounded-full" src="/upload_files/{{$agent->profile_image}}">
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{$agent->name}}</div>
                    <!-- <div class="text-gray-600">Software Engineer</div> -->
                </div>
            </div>
            <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$agent->email}} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i> {{$agent->mobile}} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="globe" class="w-4 h-4 mr-2"></i> 
                @foreach($city as $city1)
                @if($city1->id == $agent->city)
                {{$city1->city}}
                @endif
                @endforeach
                </div>
            </div>
            <!-- <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-gray-200 pt-5 lg:pt-0">
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-semibold text-theme-1 text-lg">201</div>
                    <div class="text-gray-600">Orders</div>
                </div>
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-semibold text-theme-1 text-lg">1k</div>
                    <div class="text-gray-600">Purchases</div>
                </div>
                <div class="text-center rounded-md w-20 py-3">
                    <div class="font-semibold text-theme-1 text-lg">492</div>
                    <div class="text-gray-600">Reviews</div>
                </div>
            </div> -->
        </div>
        <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
            <a data-toggle="tab" data-target="#profile" href="javascript:;" class="py-4 sm:mr-8 flex items-center active"> <i class="w-4 h-4 mr-2" data-feather="user"></i> Busisness Profile </a>
            <a data-toggle="tab" data-target="#account" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="shield"></i> Contact Details </a>
            <a data-toggle="tab" data-target="#upload_files" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="shield"></i> Upload Files </a>
            <a data-toggle="tab" data-target="#shop_time" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="settings"></i> Shop Time </a>
            <a data-toggle="tab" data-target="#booking" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="settings"></i> Booking Details </a>
            <!-- <a data-toggle="tab" data-target="#change-password" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="lock"></i> Change Password </a>
            <a data-toggle="tab" data-target="#settings" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="settings"></i> Settings </a> -->
        </div>
    </div>
    <!-- END: Profile Info -->
    <div class="tab-content mt-5">

        <div class="tab-content__pane active" id="profile">
            <div class="grid grid-cols-12 gap-6">
                
            <div class="col-span-12 xl:col-span-6">
                <div>
                    <label>Email</label>
                    <input type="text" class="input w-full border bg-gray-100 cursor-not-allowed mt-2" value="{{$agent->email}}" >
                </div>
                <div class="mt-3">
                    <label>Name</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->name}}">
                </div>
                <div class="mt-3">
                    <label>Busisness Name</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->busisness_name}}">
                </div>
                <div class="mt-3">
                    <label>Busisness ID</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->busisness_id}}">
                </div>
            </div>
            <div class="col-span-12 xl:col-span-6">
                <div>
                    <label>Trade Licence No</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->trade_license_no}}">
                </div>
                <div class="mt-3">
                    <label>Emirates ID</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->emirates_id}}">
                </div>
                <div class="mt-3">
                    <label>Vat Certificate No</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->vat_certificate_no}}">
                </div>
                <div class="mt-3">
                    <label>Passport Number</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->passport_number}}">
                </div>
            </div>


            </div>
        </div>



        <div class="tab-content__pane" id="account">
            <div class="grid grid-cols-12 gap-6">
                
            <div class="col-span-12 xl:col-span-6">
                <div class="mt-3">
                    <label>Address</label>
                    <textarea class="input w-full border mt-2">{{$agent->address}}</textarea>
                </div>
                <div class="mt-3">
                    <label>Latitute</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->latitude}}">
                </div>
                <div class="mt-3">
                    <label>Longitude</label>
                    <input type="text" class="input w-full border mt-2" placeholder="Input text" value="{{$agent->longitude}}">
                </div>
            </div>
            <div class="col-span-12 xl:col-span-6">
                <div>
                    <label>Signature</label>
                    <img src="{{$agent->signature_data}}">
                </div>
            </div>


            </div>
        </div>



        <div class="tab-content__pane" id="upload_files">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xl:col-span-6">
                <div>
                    <label>Cover Image</label>
                    <img style="width:200px;" src="/upload_files/{{$agent->cover_image}}">
                </div>
                <div>
                    <label>Trade License Copy</label>
                    <img style="width:200px;" src="/upload_files/{{$agent->trade_license}}">
                </div>
            </div>
            <div class="col-span-12 xl:col-span-6">
                <div>
                    <label>Emirated ID Copy</label>
                    <img style="width:200px;" src="/upload_files/{{$agent->emirated_id_copy}}">
                </div>
                <div>
                    <label>Passport Copy</label>
                    <img style="width:200px;" src="/upload_files/{{$agent->passport_copy}}">
                </div>
            </div>

        </div>
        </div>


        <div class="tab-content__pane" id="shop_time">
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
                    <button id="add_time" class="button text-white bg-theme-1 shadow-md mr-2">Update Shop Time</button>
                </div>
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <table id="datatable" class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="text-center border-b-2 whitespace-no-wrap">Days</th>
                                <th class="text-center border-b-2 whitespace-no-wrap">Open/Closed</th>
                                <th class="text-center border-b-2 whitespace-no-wrap">Opening Time</th>
                                <th class="text-center border-b-2 whitespace-no-wrap">Closing Time</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($shop_time as $key => $row)
                        <tr>
                            <td class="text-center border-b">{{$row->days}}</td>
                            <td class="text-center border-b">
                                @if($row->status == 1)
                                Open
                                @else
                                Closed
                                @endif
                            </td>
                            <td class="text-center border-b">{{$row->open_time}}</td>
                            <td class="text-center border-b">{{$row->close_time}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- END: Data List -->
            </div>
        </div>


        <div class="tab-content__pane" id="booking">
            <div class="grid grid-cols-12 gap-6 mt-5">
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <table id="booking_table" class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-no-wrap">#</th>
                                <th class="whitespace-no-wrap">Date</th>
                                <th class="whitespace-no-wrap">Shop Details</th>
                                <th class="whitespace-no-wrap">Customer Details</th>
                                <th class="whitespace-no-wrap">Payment Type</th>
                                <th class="whitespace-no-wrap">Total</th>
                                <th class="whitespace-no-wrap">Status</th>
                                <th class="whitespace-no-wrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- END: Data List -->
            </div>
        </div>

    </div>
</div>
<!-- END: Content -->





<!-- BEGIN: Header & Footer Modal -->
<div class="modal" id="time_modal">
    <div class="modal__content modal__content--xl">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 id="modal-title" class="font-medium text-base mr-auto">
                Update Time
            </h2>
        </div>
        <form id="time_form" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id">
        <!-- <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
        </div> -->
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table id="datatable" class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="text-center border-b-2 whitespace-no-wrap">Days</th>
                            <th class="text-center border-b-2 whitespace-no-wrap">Open/Closed</th>
                            <th class="text-center border-b-2 whitespace-no-wrap">Opening Time</th>
                            <th class="text-center border-b-2 whitespace-no-wrap">Closing Time</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$time = array('12:00 AM','12:30 AM','01:00 AM','01:30 AM','02:00 AM','02:30 AM','03:00 AM','03:30 AM','04:00 AM','04:30 AM','05:00 AM','05:30 AM','06:00 AM','06:30 AM','07:00 AM','07:30 AM','08:00 AM','08:30 AM','09:00 AM','09:30 AM','10:00 AM','10:30 AM','11:00 AM','11:30 AM','12:00 PM','12:30 PM','01:00 PM','01:30 PM','02:00 PM','02:30 PM','03:00 PM','03:30 PM','04:00 PM','04:30 PM','05:00 PM','05:30 PM','06:00 PM','06:30 PM','07:00 PM','07:30 PM','08:00 PM','08:30 PM','09:00 PM','09:30 PM','10:00 PM','10:30 PM','11:00 PM','11:30 PM');
?>
                    @foreach($shop_time as $key => $row)
                    <tr>
                        <td class="text-center border-b">
                            {{$row->days}}
                            <input value="{{$row->id}}" type="hidden" name="timing_id[]">
                        </td>
                        <td class="text-center border-b">
                            <select name="status[]" class="form-control">
                                <option value="">SELECT</option>
                                <option {{$row->status == 1 ?'selected':''}} value="1">Open</option>
                                <option {{$row->status == 2 ?'selected':''}} value="2">Closed</option>
                            </select>
                        </td>

                        <td class="text-center border-b">
                            <select name="open_time[]" class="form-control">
                                <option value="">SELECT</option>
                                @for ($i = 0; $i < 48; $i++) {
                                <option {{$row->open_time == $time[$i] ?'selected':''}} value="{{$time[$i]}}">{{$time[$i]}}</option>
                                @endfor
                            </select>
                        </td>
                        <td class="text-center border-b">
                            <select name="close_time[]" class="form-control">
                                <option value="">SELECT</option>
                                @for ($i = 0; $i < 48; $i++) {
                                <option {{$row->close_time == $time[$i] ?'selected':''}} value="{{$time[$i]}}">{{$time[$i]}}</option>
                                @endfor
                            </select>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>
        </form>
        <div class="px-5 py-3 text-right border-t border-gray-200">
            <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Cancel</button>
            <button onclick="timeUpdate()" id="saveButton" type="button" class="button w-20 bg-theme-1 text-white">Save</button>
        </div>
    </div>
</div>
<!-- END: Header & Footer Modal -->
@endsection
@section('extra-js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js
"></script>
<script type="text/javascript">
$('.agent').addClass('side-menu--active');

$('#add_time').click(function(){
    $('#time_modal').modal('show');
    $("#time_form")[0].reset();
});

var orderPageTable = $('#booking_table').DataTable({
    "processing": true,
    "serverSide": true,
    //"pageLength": 50,
    "ajax":{
        "url": '/admin/agent-booking/<?php echo $agent->id; ?>',
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"}
    },
    "columns": [
        // { data: 'DT_RowIndex', name: 'DT_RowIndex'},
        { data: 'booking_id', name: 'booking_id'},
        { data: 'booking_date', name: 'booking_date' },
        { data: 'shop_details', name: 'shop_details' },
        { data: 'customer_details', name: 'customer_details' },
        { data: 'payment_type', name: 'payment_type' },
        { data: 'total', name: 'total' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action' },
    ]
});

function timeUpdate(){
  var formData = new FormData($('#time_form')[0]);
    $.ajax({
        url : '/admin/update-time',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {                
            $("#time_form")[0].reset();
            $('#time_modal').modal('hide');            
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Update',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                location.reload();
            });
        },error: function (data) {
            var errorData = data.responseJSON.errors;
            $.each(errorData, function(i, obj) {
                //toastr.error(obj[0]);
                alert(obj[0]);
            });
        }
    });
}
</script>
@endsection
            
        