@extends('agent.layouts')
@section('extra-css')
@endsection
@section('body-section')
<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Coupon List
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button id="add_new" class="button text-white bg-theme-1 shadow-md mr-2">Add New Coupon</button>
        </div>
    </div>
    <!-- BEGIN: Datatable -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">S.No</th>
                    <th class="border-b-2 whitespace-no-wrap">Coupon Code</th>
                    <th class="border-b-2 whitespace-no-wrap">Start Date</th>
                    <th class="border-b-2 whitespace-no-wrap">End Date</th>
                    <th class="border-b-2 whitespace-no-wrap">Discount Type</th>
                    <th class="border-b-2 whitespace-no-wrap">Amount</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Action</th>
                </tr>
            </thead>
            <tbody>
                @php ($x = 0) @endphp
                @foreach($coupon as $row)
                @php $x++ @endphp
                  <tr>
                    <td>{{$x}}</td>
                    <td>
                      @if(date('Y-m-d') > $row->end_date )
                        <span style="color:red">{{$row->coupon_code}}</span>
                      @else
                        <span style="color:green">{{$row->coupon_code}}</span>
                      @endif
                    </td>
                    <td>{{$row->start_date}}</td>
                    <td>{{$row->end_date}}</td>
                    <td>
                      @if($row->discount_type == '1')
                      Discount from product
                      @elseif($row->discount_type == '2')
                      Discount % from product
                      @elseif($row->discount_type == '3')
                      Discount from total cart
                      @else
                      Discount % from total cart
                      @endif
                    </td>
                    <td>{{$row->amount}}</td>
                    <td class="table-report__action w-56">
                        <div class="flex justify-center items-center">
                            <a class="flex items-center mr-3" href="/agent/view-coupon/{{$row->id}}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                            <a onclick="Delete({{$row->id}})" class="flex items-center justify-center text-theme-9" href="javascript:;"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
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

@endsection
@section('extra-js')

<script type="text/javascript">
$('.coupon').addClass('top-menu--active');

var action_type;
$('#add_new').click(function(){
    window.location.href="/agent/add-coupon/";
});


function Delete(id){
    var r = confirm("Are you sure");
    if (r == true) {
      $.ajax({
        url : '/agent/delete-coupon/'+id,
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