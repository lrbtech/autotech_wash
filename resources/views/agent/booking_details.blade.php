@extends('agent.layouts')
@section('extra-css')
@endsection
@section('body-section')
<!-- BEGIN: Content -->
<div class="content">
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            View Booking Details
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="/agent/booking"><button class="button text-white bg-theme-1 shadow-md mr-2">Back</button></a>
            <a target="_blank" href="/booking-print/{{$booking->id}}"><button class="button text-white bg-theme-1 shadow-md mr-2">Print</button></a>
            <!-- <div class="dropdown relative ml-auto sm:ml-0">
                <button class="dropdown-toggle button px-2 box text-gray-700">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                </button>
                <div class="dropdown-box mt-10 absolute w-40 top-0 right-0 z-20">
                    <div class="dropdown-box__content box p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Export Word </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Export PDF </a>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <!-- BEGIN: Invoice -->
    <div id="printarea" class="intro-y box overflow-hidden mt-5">
        <div class="flex flex-col lg:flex-row pt-10 px-5 sm:px-20 sm:pt-20 lg:pb-20 text-center sm:text-left">
            @if($booking->status == 0)
            <div class="font-semibold text-theme-1 text-3xl">Order Placed</div>
            @elseif($booking->status == 1)
            <div class="font-semibold text-theme-1 text-3xl">Order Accepted</div>
            @elseif($booking->status == 2)
            <div class="font-semibold text-theme-1 text-3xl">Received</div>
            @elseif($booking->status == 3)
            <div class="font-semibold text-theme-1 text-3xl">Processing</div>
            @elseif($booking->status == 4)
            <div class="font-semibold text-theme-1 text-3xl">Delivered</div>
            @endif


            <div class="mt-20 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-xl text-theme-1 font-medium">{{$shop->busisness_name}}</div>
                <div class="mt-1">{{$shop->email}}</div>
                <div class="mt-1">{{$shop->mobile}}</div>
                <div class="mt-1">{{$shop->address}}</div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-center sm:text-left">
            <div>
                <div class="text-base text-gray-600">Client Details</div>
                <div class="text-lg font-medium text-theme-1 mt-2">{{$customer->first_name}} {{$customer->last_name}}</div>
                <div class="mt-1">{{$customer->mobile}}</div>
                <div class="mt-1">{{$booking->address}}</div>
            </div>
            <div class="mt-10 lg:mt-0 lg:ml-auto">
                <div class="text-base text-gray-600">Vehicle Details</div>
                <div class="text-lg font-medium text-theme-1 mt-2">{{$vehicle->brand}} {{$vehicle->vehicle_name}}</div>
                <div class="mt-1">{{$colour->name}}</div>
                <div class="mt-1">{{$vehicle->registration_city}} {{$vehicle->registration_code}} {{$vehicle->registration_number}}</div>
            </div>
            <div class="mt-10 lg:mt-0 lg:ml-auto lg:text-right">
                <div class="text-base text-gray-600">Receipt</div>
                <div class="text-lg text-theme-1 font-medium mt-2">#{{$booking->booking_id}}</div>
                <div class="mt-1">{{date('d-m-Y',strtotime($booking->date))}}</div>
            </div>
        </div>
        <div class="px-5 sm:px-16 py-10 sm:py-20">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-b-2 whitespace-no-wrap">DESCRIPTION</th>
                            <th class="border-b-2 whitespace-no-wrap"></th>
                            <th class="border-b-2 whitespace-no-wrap"></th>
                            <th class="border-b-2 text-right whitespace-no-wrap">PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($booking_service)>0)
                        @foreach($booking_service as $row)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{$row->service_name}}</div>
                                <div class="text-gray-600 text-xs whitespace-no-wrap">Service</div>
                            </td>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32 font-medium">AED {{$row->price}}</td>
                        </tr>
                        @endforeach
                        @endif
                        @if(count($booking_product)>0)
                        @foreach($booking_product as $row)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{$row->product_name}}</div>
                                <div class="text-gray-600 text-xs whitespace-no-wrap">Product</div>
                            </td>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32 font-medium">AED {{$row->price}}</td>
                        </tr>
                        @endforeach
                        @endif
                        @if(count($booking_package)>0)
                        @foreach($booking_package as $row)
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-no-wrap">{{$row->package_name}}</div>
                                <div class="text-gray-600 text-xs whitespace-no-wrap">Package</div>
                            </td>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32 font-medium">AED {{$row->price}}</td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32">Sub Total</td>
                            <td class="text-right border-b w-32 font-medium">AED {{$booking->subtotal}}</td>
                        </tr>
                        @if($booking->coupon_value != '')
                        <tr>
                            <td class="text-right border-b w-32"></td>
                            <td class="text-right border-b w-32"></td>
                            <td style="color:green;" class="text-right border-b w-32">Discount({{$booking->coupon_code}})</td>
                            <td style="color:green;" class="text-right border-b w-32 font-medium">AED {{$booking->coupon_value}}</td>
                        </tr>        
                        @endif            
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <!-- <div class="text-center sm:text-left mt-10 sm:mt-0">
                <div class="text-base text-gray-600">Bank Transfer</div>
                <div class="text-lg text-theme-1 font-medium mt-2">Elon Musk</div>
                <div class="mt-1">Bank Account : 098347234832</div>
                <div class="mt-1">Code : LFT133243</div>
            </div> -->
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="text-base text-gray-600">Total Amount</div>
                <div class="text-xl text-theme-1 font-medium mt-2">AED {{$booking->total}}</div>
                <div class="mt-1 tetx-xs">Taxes included</div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->
</div>
<!-- END: Content -->
@endsection
@section('extra-js')
<script type="text/javascript">
$('.booking').addClass('top-menu--active');

function PrintBooking(id){
  $.ajax({
    url : '/booking-print/'+id,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        var mywindow = window.open('', 'BIlling Application', 'height=600,width=800');
        var is_chrome = Boolean(mywindow.chrome);
        mywindow.document.write(data.html);
        mywindow.document.close(); 
        if (is_chrome) {
            setTimeout(function() {
            mywindow.focus(); 
            mywindow.print(); 
            mywindow.close();
            location.reload();
            }, 250);
        } else {
            mywindow.focus(); 
            mywindow.print(); 
            mywindow.close();
            location.reload();
        }
        //PrintDiv(data);
        
    }
  });
}
</script>
@endsection