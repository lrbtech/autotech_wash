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
                    <h1 class="title mb-19 white-color text-center">FAQ</h1>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="rs-faq inner pt-92 md-pt-72 pb-100 md-pb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 pr-55 md-pr-15 md-mb-30">
                            <div class="sec-title mb-43">
                                <div class="sub-title primary">Feel free to contact us</div>
                                <h2 class="title mb-16">Do You Have Any Questions?</h2>
                                <div class="desc">Our Chat sysytem will help you with better reach to all your questions we are avilable single click away in our App.</div>
                            </div>
                            <div id="accordion" class="accordion">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="card-link" data-toggle="collapse" href="#collapseOne">Where should I incorporate my business?</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">You can join us to provide the service in your regions you can register with AUTOTECH website now with all your documents.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">Where can I find market research reports?</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">we will be happy to provide such details to our partners on the market level & the service we affrod.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">What is social distancing and how can we do that?</a>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                                        <div class="card-body">We have geared up with all the services we sanitize the vehcile completely.</div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <form class="sidebar-form mt-8">
                                <h3 class="title white-color mb-36">More Questions</h3>
                                <input type="text" name="name" placeholder="Name" required="">
                                <input type="email" name="email" placeholder="E-mail" required="">
                                <input type="text" name="number" placeholder="Phone Number">
                                <textarea placeholder="Enter Query Here"></textarea>
                                <button class="readon" type="submit">Submit Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div> 
        <!-- Main content End -->

@endsection
@section('extra-js')
<script type="text/javascript">
$('.faq').addClass('current-menu-item');
</script>
@endsection