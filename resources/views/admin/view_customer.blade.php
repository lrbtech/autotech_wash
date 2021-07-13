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
            <!-- <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img class="rounded-full" src="/upload_files/{{$customer->image}}">
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{$customer->first_name}} {{$customer->last_name}}</div>
                    <div class="text-gray-600">Software Engineer</div>
                </div>
            </div> -->
            <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="user" class="w-4 h-4 mr-2"></i> {{$customer->first_name}} {{$customer->last_name}} </div>
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{$customer->email}} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="phone" class="w-4 h-4 mr-2"></i> {{$customer->mobile}} </div>
                <!-- <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="globe" class="w-4 h-4 mr-2"></i> 
                </div> -->
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
            <a data-toggle="tab" data-target="#booking" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="settings"></i> Booking Details </a>
            <!-- <a data-toggle="tab" data-target="#change-password" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="lock"></i> Change Password </a>
            <a data-toggle="tab" data-target="#settings" href="javascript:;" class="py-4 sm:mr-8 flex items-center"> <i class="w-4 h-4 mr-2" data-feather="settings"></i> Settings </a> -->
        </div>
    </div>
    <!-- END: Profile Info -->
    <div class="tab-content mt-5">

        <div class="tab-content__pane active" id="booking">
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

@endsection
@section('extra-js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js
"></script>
<script type="text/javascript">
$('.customer').addClass('side-menu--active');


var orderPageTable = $('#booking_table').DataTable({
    "processing": true,
    "serverSide": true,
    //"pageLength": 50,
    "ajax":{
        "url": '/admin/customer-booking/<?php echo $customer->id; ?>',
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

</script>
@endsection
            
        