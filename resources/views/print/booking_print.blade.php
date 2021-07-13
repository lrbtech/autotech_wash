<style type="text/css" media="all">
#lineItem tr:nth-child(even) {
  background-color: #fafaf8;
}
#lineItem td{
  vertical-align: middle;
}
</style>

<html style="border: 0; margin: 0; padding: 0;">
<head>
  <title>Invoice</title>
</head>
<body style="border: 0; margin: 0; padding: 0;">
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding:0; margin: 0 auto;font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px;border-top: 8px solid #2D87BA; background: white;">
  <tbody>
    <tr>
      <td valign="top">
        <table border="0" cellspacing="0" cellpadding="0" width="100%" style="">
          <tbody>
            <tr>
              <td valign="top">
                <div style="height:180px; overflow: hidden;">
                  <div style="padding-top:40px; padding-left: 40px; float: left; width: 30%">
                    <h2 style="font-weight:bold; font-size: 32px; color: #2d87ba; max-width: 85%; line-height: 1.1; margin: 10px 0 0; padding: 0; float: left">Invoice</h2>
                  </div>
                  <div style="color:black; text-align: right; padding-top:40px; padding-right: 40px; float: right;">
                    <span style="color:black;font-weight:bold;">
                      <b>{{$shop->busisness_name}}</b><br>
                    </span>
                    <span style="color:black;font-weight:bold;">
                      <b>{{$shop->email}}</b><br>
                    </span>
                    <span style="color:black;font-weight:bold;">
                      <b>{{$shop->mobile}}</b><br>
                    </span>
                    <span id="tmp_org_address">
                    {{$shop->address}}
                    </span>
                  </div>
                </div>
                
                <table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom: 20px">
                  <tbody>
                    <tr>
                      <td valign="top" width="60%" style="color:#000; padding: 20px 10px 20px 40px; background: #EDEDED; border-right: 2px solid white;">
                        <h3 style="font-size: 13px;"><label id="tmp_billing_address_label">BILL TO</label>:</h3>
                        <p style="font-size: 14px">
                          <b>{{$customer->first_name}} {{$customer->last_name}}</b><br>
                          <span style="width:100px;" id="tmp_billing_address" style="white-space: pre-wrap;">{{$booking->address}}
                          </span>
                          <br><span id="tmp_billing_address" style="white-space: pre-wrap;">{{$customer->mobile}}<br>{{$customer->email}}
                          </span>
                        </p>
                        <!--h3 style="font-size: 14px">SHIP TO:</h3>
                        <p style="font-size: 14px"><b>${Invoices.Shipping Street}</b><br>${Invoices.Shipping City}<br>${Invoices.Shipping State}<br>${Invoices.Shipping Country}<br>${Invoices.Shipping Code}</p-->
                      </td>
                      <td width="10%" valign="top" style="color:#fff; padding: 20px 40px 20px 0; background: #2d87ba;text-align: right;">
                        <!-- <p style="font-size: 14px">Due date:</p>
                        <h3 style="font-size: 18px"><span id="tmp_due_date">DueDate</span></h3> -->
                        
                      </td>
                      <td width="30%" valign="top" style="color:#000; padding: 20px 10px; background: #dde9ef; border-right: 2px solid white;">
                        <p style="font-size: 14px">Booking Date:</p>
                        <h3 style="font-size: 14px">{{date('d-m-Y',strtotime($booking->date))}}</h3>
                        <p style="font-size: 14px">Booking ID:</p>
                        <h3 style="font-size: 13px;word-wrap:break-word;max-width: 170px"><span id="tmp_entity_number"><b> #{{$booking->booking_id}}</b></span></h3>
                        @if($booking->status == 0)
                        <h3 style="font-size: 13px;word-wrap:break-word;max-width: 170px"><span id="tmp_entity_number"><b>Order Placed</b></span></h3>
                        @elseif($booking->status == 1)
                        <h3 style="font-size: 13px;word-wrap:break-word;max-width: 170px"><span id="tmp_entity_number"><b>Order Accepted</b></span></h3>
                        @elseif($booking->status == 2)
                        <h3 style="font-size: 13px;word-wrap:break-word;max-width: 170px"><span id="tmp_entity_number"><b>Received</b></span></h3>
                        @elseif($booking->status == 3)
                        <h3 style="font-size: 13px;word-wrap:break-word;max-width: 170px"><span id="tmp_entity_number"><b>Processing</b></span></h3>
                        @elseif($booking->status == 4)
                        <h3 style="font-size: 13px;word-wrap:break-word;max-width: 170px"><span id="tmp_entity_number"><b>Delivered</b></span></h3>
                        @endif
                      </td>
                      
                    </tr>
                  </tbody>
                </table>
                <table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family: Verdana, Arial, Helvetica, sans-serif;color:#000; font-size: 12px;">
                  <thead style="text-transform: uppercase;color:#fff; padding: 10px 10px 10px 10px; background: #2d87ba; border-right: 2px solid white;">
                    <tr>
                      <td style="font-weight:bold;border-bottom:1px solid #EDEDED;  padding: 7px 5px 7px 40px;">Description</td>
                      <td style="font-weight:bold;border-bottom:1px solid #2d87ba; padding: 7px 40px 7px 0px; text-align: right;">Price</td>
                    </tr>
                  </thead>
                  <tbody id="lineItem">
                    @if(count($booking_service)>0)
                    @foreach($booking_service as $row)
                    <tr>
                        <td style="border-bottom:1px solid #EDEDED; padding: 7px 5px 7px 40px; font-size: 12px;">
                            <span style="word-wrap: break-word;">{{$row->service_name}}</span><br>
                            <span style="word-wrap: break-word;">(Service)</span>
                        </td>
                        <td valign="top" style="border-bottom:1px solid #2d87ba; padding: 7px 40px 7px 0; font-size: 12px; text-align: right;">AED {{$row->price}}</td>
                    </tr>
                    @endforeach
                    @endif
                    @if(count($booking_product)>0)
                    @foreach($booking_product as $row)
                    <tr>
                        <td style="border-bottom:1px solid #EDEDED; padding: 7px 5px 7px 40px; font-size: 12px;">
                            <span style="word-wrap: break-word;">{{$row->product_name}}</span><br>
                            <span style="word-wrap: break-word;">(Product)</span>
                        </td>
                        <td valign="top" style="border-bottom:1px solid #2d87ba; padding: 7px 40px 7px 0; font-size: 12px; text-align: right;">AED {{$row->price}}</td>
                    </tr>
                    @endforeach
                    @endif
                    @if(count($booking_package)>0)
                    @foreach($booking_package as $row)
                    <tr>
                        <td style="border-bottom:1px solid #EDEDED; padding: 7px 5px 7px 40px; font-size: 12px;">
                            <span style="word-wrap: break-word;">{{$row->package_name}}</span><br>
                            <span style="word-wrap: break-word;">(Package)</span>
                        </td>
                        <td valign="top" style="border-bottom:1px solid #2d87ba; padding: 7px 40px 7px 0; font-size: 12px; text-align: right;">AED {{$row->price}}</td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                  <tbody>
                    <tr>
                        <td style="padding: 7px 40px 7px 5px; text-align: right;" id="tmp_total">Sub Total</td>
                        <td style="padding: 7px 40px 7px 5px; text-align: right;" id="tmp_total"><b>AED {{$booking->subtotal}}</b></td>
                    </tr>
                    @if($booking->coupon_value != '')
                    <tr>
                        <td style="padding: 7px 40px 7px 5px; text-align: right;" id="tmp_total">Discount({{$booking->coupon_code}})</td>
                        <td style="padding: 7px 40px 5px 5px; text-align: right; color: green">AED {{$booking->coupon_value}}</td>
                    </tr>        
                    @endif  
                    <tr>
                      <td style="border-bottom:1px solid #EDEDED; border-bottom:1px solid #dde9ef;border-top:1px solid #dde9ef;padding: 10px 5px; color:#2d87ba; font-size: 13px;padding: 7px 40px 7px 5px;text-align: right"><b>Total</b></td>
                      <td style="border-bottom:1px solid #2d87ba;border-top:1px solid #2d87ba;padding: 10px 40px 10px 0; text-align: right; color:#2d87ba; font-size: 13px"  id="tmp_balance_due"><b>AED {{$booking->total}}</b></td>
                    </tr>
                    <tr>
                      <td style="border-bottom:1px solid #EDEDED; padding: 10px 5px;border-bottom:1px solid #dde9ef;border-top:1px solid #dde9ef;">
                        @if($booking->payment_status == 0)
                          <h4 style="color: #FF0000;font-size: 24px;margin-left: 100px;">UN PAID</h4>
                        @else
                          <h4 style="color: #32CD32;font-size: 24px;margin-left: 100px;">PAID</h4>
                        @endif
                      </td>
                      <!-- <td style="border-bottom:1px solid #EDEDED; border-bottom:1px solid #dde9ef;border-top:1px solid #dde9ef;padding: 5px 5px; color:#2d87ba; font-size: 13px">
                        @if($booking->payment_status == 1)
                        @if($booking->payment_type == 0)
                          <h5 style="color: #32CD32;font-size: 14px;margin-left: 100px;">Cash on Delivery (COD)</h5>
                        @endif
                        @endif
                      </td> -->
                    </tr>
                  </tbody>
                </table>

<style media="print">
    #invoice-footer {
        width: 100%;
        display: block;
        position: fixed;
        bottom: 0;
    }
</style>
<style media="screen">
    #invoice-footer { 
        position: fixed;
        margin-top: -5em; /* negative value of footer height */
        height: 5em;
        clear: both;
        margin-left: 30px;
        margin-right: 20px;
    }
</style>
                <!-- <div id="invoice-footer" style="margin-top: 60px; padding: 0 0 0 20px; overflow: hidden;border-top:1px solid #dadada; page-break-inside: avoid;">
                  <div style="color:gray;padding: 0px 0px 0 0px; float: left; width: 60%;">
                    <h3 style="margin: 0 0 0px; font-size: 13px; color: #2d87ba;"><label id="tmp_terms_label">Terms and Conditions</label></h3>
                    <pre style="color:#000; padding: 0px 20px 0 0; display: block; font-size: 12px; font-family: Verdana, Helvetica, Arial, sans-serif;" wrap="soft">1.Goods once Sold wil not be taken back</pre>
                    <pre style="color:#000; padding: 0px 20px 0 0; display: block; font-size: 12px; font-family: Verdana, Helvetica, Arial, sans-serif;" wrap="soft">2.Manufacturer warranty only.</pre>
                  </div>
                </div> -->
                
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
</body>
</html>