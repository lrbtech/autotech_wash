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
                                <h1 class="title mb-19 white-color text-center">Services</h1>
                            </div>
                        </div>
                    </div>
                    
                </div>
</div>

            <!-- Services Section Start -->
            <div id="rs-services" class="rs-services style1 modify2 pt-100 pb-84 md-pt-80 md-pb-64">
                <div class="container">
                    <div class="row gutter-16">
                        <div class="col-lg-4 col-sm-6 mb-16">
                            <div class="service-wrap">
                                <div class="icon-part">
                                    <img src="/website/assets/images/services/icons/car.png" alt="">
                                </div>
                                <div class="content-part">
                                    <h5 class="title"><a href="/car-wash-services">Car Wash Services</a></h5>
                                    <div class="desc">We always provide people a complete solution focused of any business.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-16">
                            <div class="service-wrap">
                                <div class="icon-part">
                                    <img src="/website/assets/images/services/icons/garage.png" alt="">
                                </div>
                                <div class="content-part">
                                    <h5 class="title"><a href="/garage-services">Garage Services</a></h5>
                                    <div class="desc">We always provide people a complete solution focused of any business.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-16">
                            <div class="service-wrap">
                                <div class="icon-part">
                                    <img src="/website/assets/images/services/icons/tow-truck.png" alt="">
                                </div>
                                <div class="content-part">
                                    <h5 class="title"><a href="/pickup-services">Pickup Services</a></h5>
                                    <div class="desc">We always provide people a complete solution focused of any business.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Services Section End -->

            <!-- Cta Section Start -->
            <div class="rs-cta bg21 pt-90 pb-100 md-pt-68 md-pb-80">
                <div class="container">
                    <div class="sec-title text-center">
                        <div class="sub-title modify white">Any plan to start a project</div>
                        <h2 class="title3 white-color">Our Experts always ready to work <br> with you.</h2>
                        <div class="btn-part">
                            <a class="readon banner-style" href="/contact">Get started</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cta Section End -->

        </div> 
        <!-- Main content End -->

@endsection
@section('extra-js')
<script type="text/javascript">
$('.service').addClass('current-menu-item');
</script>
@endsection