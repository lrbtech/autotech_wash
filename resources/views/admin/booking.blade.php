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
    <h2 class="intro-y text-lg font-medium mt-10">
        All Booking
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
            <!-- <button class="button text-white bg-theme-1 shadow-md mr-2">Add New Product</button> -->
            <div class="mt-3">
                <div class="sm:grid grid-cols-5 gap-6">
                    <div class="relative mt-2">
                        <label>From Date</label>
                        <input type="date" class="input w-full border mt-2" name="from_date" id="from_date">
                    </div>
                    <div class="relative mt-2">
                        <label>To Date</label>
                        <input type="date" class="input w-full border mt-2" name="to_date" id="to_date">
                    </div>
                    <div class="relative mt-2">
                        <label>Select the Shop</label>
                        <select id="shop_id" name="shop_id" class="select2 w-full mt-2 input">
                        <option value="shop">All Shops</option>
                        @foreach ($shop as $shop1)
                        <option value="{{$shop1->id}}">{{$shop1->busisness_name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="relative mt-2">
                        <label>Status</label>
                        <select id="status" name="status" class="input w-full border mt-2">
                        <option value="status">SELECT</option>
                        <option value="0">Order Placed</option>
                        <option value="1">Order Accepted</option>
                        <option value="2">Received</option>
                        <option value="3">Processing</option>
                        <option value="4">Delivered</option>
                        </select>
                    </div>
                    <div class="relative mt-2">
                        <button id="search" type="button" class="button w-24 bg-theme-1 text-white">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table id="datatable" class="table table-report -mt-2">
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
<!-- END: Content -->

@endsection
@section('extra-js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js
"></script>
<script type="text/javascript">
$('.booking').addClass('side-menu--active');

function search_url(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  var fdate;
  var tdate;
  if(from_date!=""){
    fdate = from_date;
  }else{
    fdate = '1';
  }
  if(to_date!=""){
    tdate = to_date;
  }else{
    tdate = '1';
  }
  var shop_id = $('#shop_id').val();
  var status = $('#status').val();
  return '/admin/get-booking/'+fdate+'/'+tdate+'/'+shop_id+'/'+status;
}

var orderPageTable = $('#datatable').DataTable({
    "processing": true,
    "serverSide": true,
    //"pageLength": 50,
    "ajax":{
        "url": search_url(),
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

$('#search').click(function(){
    var new_url = search_url();
    orderPageTable.ajax.url(new_url).load(null, false);
    //orderPageTable.draw();
});

</script>
@endsection
            
        