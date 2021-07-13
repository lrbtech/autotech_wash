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
        Product Request
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
            <!-- <button class="button text-white bg-theme-1 shadow-md mr-2">Add New Product</button> -->
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table id="datatable" class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-no-wrap">Shop Details</th>
                        <th class="whitespace-no-wrap">Product</th>
                        <th class="whitespace-no-wrap">Image</th>
                        <th class="whitespace-no-wrap">Price</th>
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
$('.product').addClass('side-menu--active');

// function search_url(){
//   var from_date = $('#from_date').val();
//   var to_date = $('#to_date').val();
//   var fdate;
//   var tdate;
//   if(from_date!=""){
//     fdate = from_date;
//   }else{
//     fdate = '1';
//   }
//   if(to_date!=""){
//     tdate = to_date;
//   }else{
//     tdate = '1';
//   }
//   var shop_id = $('#shop_id').val();
//   return '/admin/get-booking/'+fdate+'/'+tdate+'/'+shop_id;
// }

var orderPageTable = $('#datatable').DataTable({
    "processing": true,
    "serverSide": true,
    //"pageLength": 50,
    "ajax":{
        "url": '/admin/get-product',
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"}
    },
    "columns": [
        // { data: 'DT_RowIndex', name: 'DT_RowIndex'},
        { data: 'shop_details', name: 'shop_details'},
        { data: 'product', name: 'product' },
        { data: 'image', name: 'image' },
        { data: 'price', name: 'price' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action' },
    ]
});

// $('#search').click(function(){
//     var new_url = search_url();
//     orderPageTable.ajax.url(new_url).load(null, false);
//     //orderPageTable.draw();
// });

function UpdateStatus(id,status){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/admin/update-product-status/'+id+'/'+status,
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
                var new_url = '/admin/get-product';
                orderPageTable.ajax.url(new_url).load(null, false);
            });
        }
      });
    } 
}
</script>
@endsection
            
        