@extends('agent.layouts')
@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
@endsection
@section('body-section')
<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        All Booking
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
            <!-- <button class="button text-white bg-theme-1 shadow-md mr-2">Add New Product</button> -->
            <div class="mt-3">
                <div class="sm:grid grid-cols-4 gap-6">
                    <div class="relative mt-2">
                        <label>From Date</label>
                        <input type="date" class="input w-full border mt-2" name="from_date" id="from_date">
                    </div>
                    <div class="relative mt-2">
                        <label>To Date</label>
                        <input type="date" class="input w-full border mt-2" name="to_date" id="to_date">
                    </div>
                    <div class="relative mt-2">
                        <label>Status</label>
                        <select id="status" name="status" class="input w-full border mt-2">
                        <option value="status">SELECT</option>
                        <option value="0">Order Placed</option>
                        <option value="1">Order Accepted</option>
                        <option value="2">Received</option>
                        <option value="3">Processing</option>
                        <option value="4">Completed</option>
                        <option value="5">Delivered</option>
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
                        <th class="whitespace-no-wrap">Customer Details</th>
                        <th class="whitespace-no-wrap">Payment Type</th>
                        <th class="whitespace-no-wrap">Total</th>
                        <th class="whitespace-no-wrap">Payment Status</th>
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
$('.booking').addClass('top-menu--active');

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
  var status = $('#status').val();
  return '/agent/get-booking/'+fdate+'/'+tdate+'/'+status;
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
        { data: 'customer_details', name: 'customer_details' },
        { data: 'payment_type', name: 'payment_type' },
        { data: 'total', name: 'total' },
        { data: 'payment_status', name: 'payment_status' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action' },
    ]
});

$('#search').click(function(){
    var new_url = search_url();
    orderPageTable.ajax.url(new_url).load(null, false);
    //orderPageTable.draw();
});

function UpdatePayment(id){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/agent/update-booking-payment/'+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Update',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                var new_url = search_url();
                orderPageTable.ajax.url(new_url).load(null, false);
            });
        }
      });
    } 
}

function UpdateStatus(id,status){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/agent/update-booking-status/'+id+'/'+status,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            Swal.fire({
                //title: "Please Check Your Email",
                text: 'Successfully Update',
                type: "success",
                confirmButtonClass: 'button text-white bg-theme-1 shadow-md mr-2',
                buttonsStyling: false,
            }).then(function() {
                var new_url = search_url();
                orderPageTable.ajax.url(new_url).load(null, false);
            });
        }
      });
    } 
}

</script>
@endsection
            
        