@extends('page.layout')
@section('extra-css')

@endsection
@section('body-section')
<!-- Main content Start -->
<div class="main-content">


<div class="rs-banner style2n">
    <div class="container relative">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-part">
                    <h1 class="title mb-19 white-color text-center">About Us</h1>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div id="rs-about" class="rs-about style1 pt-100 pb-100 md-pt-80 md-pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 pr-40 md-pl-pr-15 md-mb-21">
                <div class="row gutter-20">
                    <div class="col-12">
                        <img src="/website/assets/images/about/new-about.png" alt="" style="width: 100%;">
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-6 pl-20 md-pl-pr-15">
                <div class="sec-title mb-23 pr-85">
                    <div class="sub-title primary">About Us</div>
                    <h2 class="title mb-20">We Provides Quality services.</h2>
                    <p class="desc mb-0">Single HUB point for car to get serviced in one zone.</p>
                </div>
                <ul class="listing-style">
                    <li>we provide extensive WASH in affordable price.</li>
                    <li>Our services are WASH IN-HOUSE / WASH NOW.</li>
                    <li>Our agenda is to provide the better and reliable services within UAE</li>
                    <li>We commit to provide services in modern world</li>
                </ul>
                <div class="btn-part mt-43">
                    <a class="readon modify" href="/service">Discover More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rs-services style1 pt-100 pb-84 md-pt-80 md-pb-64">
    <div class="container">
        <div class="row gutter-16">
            <div class="col-lg-3 col-sm-6 mb-16">
                <div class="service-wrap">
                    <div class="icon-part">
                        <img src="/website/assets/images/services/icons/1.png" alt="">
                    </div>
                    <div class="content-part">
                        <h5 class="title"><a href="javascript:void(0)">Solution Focused</a></h5>
                        <div class="desc"> We have provide complete solution focus on car needs.</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-16">
                <div class="service-wrap">
                    <div class="icon-part">
                        <img src="/website/assets/images/services/icons/2.png" alt="">
                    </div>
                    <div class="content-part">
                        <h5 class="title"><a href="javascript:void(0)">Customer Oriented</a></h5>
                        <div class="desc"> We have provide complete support for car needs.</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-16">
                <div class="service-wrap">
                    <div class="icon-part">
                        <img src="/website/assets/images/services/icons/3.png" alt="">
                    </div>
                    <div class="content-part">
                        <h5 class="title"><a href="javascript:void(0)">99.99% Success</a></h5>
                        <div class="desc"> As been people choice for better and affrobale price.</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-16">
                <div class="service-wrap">
                    <div class="icon-part">
                        <img src="/website/assets/images/services/icons/4.png" alt="">
                    </div>
                    <div class="content-part">
                        <h5 class="title"><a href="javascript:void(0)">Decision Maker</a></h5>
                        <div class="desc"> We make life easy order now to experiance the chnage.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div> 
<!-- Main content End -->



@endsection
@section('extra-js')
<script type="text/javascript">
$('.about').addClass('current-menu-item');
</script>
@endsection