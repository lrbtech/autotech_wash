@extends('agent.layouts')
@section('extra-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.fa {
  font-size: 25px;
}

.checked {
  color: orange;
}
</style>
@endsection
@section('body-section')
<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        All Reviews
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
                        <!-- <th class="whitespace-no-wrap">Shop Details</th> -->
                        <th class="whitespace-no-wrap">Customer Details</th>
                        <th class="whitespace-no-wrap">Reviews</th>
                        <th class="whitespace-no-wrap">Comments</th>
                        <th class="whitespace-no-wrap">Status</th>
                        <!-- <th class="whitespace-no-wrap">Action</th> -->
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
$('.reviews').addClass('top-menu--active');

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
  return '/agent/get-reviews/'+fdate+'/'+tdate;
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
        { data: 'date', name: 'date'},
        //{ data: 'shop_details', name: 'shop_details' },
        { data: 'customer_details', name: 'customer_details' },
        { data: 'reviews', name: 'reviews' },
        { data: 'comments', name: 'comments' },
        { data: 'status', name: 'status' },
        //{ data: 'action', name: 'action' },
    ]
});

$('#search').click(function(){
    var new_url = search_url();
    orderPageTable.ajax.url(new_url).load(null, false);
    //orderPageTable.draw();
});

function Delete(id,status){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/agent/delete-reviews/'+id+'/'+status,
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
            
        