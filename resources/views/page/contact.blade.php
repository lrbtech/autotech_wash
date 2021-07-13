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
                    <h1 class="title mb-19 white-color text-center">Contact Us</h1>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="rs-contact" class="rs-contact inner pt-100 md-pt-80">
                <div class="container">
                    <div class="content-info-part mb-60">
                        <div class="row gutter-16">
                            <div class="col-lg-4 md-mb-30">
                                <div class="info-item">
                                    <div class="icon-part">
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <div class="content-part">
                                        <h4 class="title">Phone Number</h4>
                                        <a href="tel:++971567100733">+971 56 710 0733</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 md-mb-30">
                                <div class="info-item">
                                    <div class="icon-part">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="content-part">
                                        <h4 class="title">Email Address</h4>
                                        <a href="mailto:info@lrbinfotech.com">info@lrbinfotech.com</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="info-item">
                                    <div class="icon-part">
                                        <i class="fa fa-map-o"></i>
                                    </div>
                                    <div class="content-part">
                                        <h4 class="title">Office Address</h4>
                                        <p>873, Floor No- 8, Al Ghaith Tower, UAE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-form-part">
                        <div class="row md-col-padding">
                            <div class="col-md-5 custom1 pr-0">
                                <div class="img-part"></div>
                            </div>
                            <div class="col-md-7 custom2 pl-0">
                                <div id="form-messages"></div>
                                <form id="contact-form" method="post" action="mailer.php">
                                    <div class="sec-title mb-53 md-mb-42">
                                        <div class="sub-title white-color">Let's Talk</div>
                                        <h2 class="title white-color mb-0">Get In Touch</h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="name" placeholder="Name" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" placeholder="E-mail" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="phone" placeholder="Phone Number" required="">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="website" placeholder="Mention Service" required="">
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="message" placeholder="Your Message Here" required=""></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="readon modify">Submit Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="g-map mt-100 md-mt-80">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d465130.3070319369!2d54.27841717845559!3d24.387198385250613!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e440f723ef2b9%3A0xc7cc2e9341971108!2sAbu%20Dhabi!5e0!3m2!1sen!2sae!4v1620656514764!5m2!1sen!2sae" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>




        </div> 
        <!-- Main content End -->

@endsection
@section('extra-js')
<script type="text/javascript">
$('.contact').addClass('current-menu-item');
</script>
@endsection