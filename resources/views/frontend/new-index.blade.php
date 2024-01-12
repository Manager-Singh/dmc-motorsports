@extends('frontend.layouts.master')
@section('title','DMC Motorsports || HOME PAGE')
@section('main-content')

   

	

    <div class="container-fluid bg-white pt-3 px-lg-5" style="background: #ededed !important;">
        
    @include('frontend.partials.search')
    </div>

    <div class="container-fluid p-0" >
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{asset('frontend/img/hero-banner-1.jpg')}}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
							<h2 class="display-1mb-md-4">Warehouse Clearance Sale</h2>
                            <h4 class="text-uppercase mb-md-3">Kick 2024 Off Right With Up To 75% Off</h4>                           
                            <a href="{{route('product-grids')}}" class="btn btn-primary mt-2">Shop Now</a>
                        </div>
                    </div>
                </div>
 
            </div>
            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>

    <div class="container-fluid py-2" style="border-top:1px solid #ccc;">
        <div class="container pb-3">
            <div class="row mt-3 categories">                
                <ul class="partner-logo">
					<li><a href=""><img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" /></a></li>
					<li><a href=""><img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" /></a></li>
					<li><a href=""><img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" /></a></li>
					<li><a href=""><img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" /></a></li>
					<li><a href=""><img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" /></a></li>
					<li><a href=""><img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" /></a></li>
					<li><a href=""><img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" /></a></li>
				
				</ul>
            </div>
        </div>
    </div>

	<div class="container-fluid py-2" style="background: whitesmoke;">
        <div class="container pt-5 pb-3">
            <h2 class="display-5 text-uppercase text-center mb-5">Top Categories</h2>
            <div class="row mt-3 categories">
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
						<img src="{{asset('frontend/img/Homepage_Dirt.jpg')}}" />      
						<div class="content">
							<h4 class="text-uppercase m-0"><a href="{{route('new-product-cat',192)}}"> Apparel	 </a></h4>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[192,'Headgear'])}}">Apparel Headgear</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[192,'Accessories'])}}">Apparel Accessories</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[192,'Tools'])}}">Apparel Tools</a></p>
						</div>	
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
                        <img src="{{asset('frontend/img/Homepage_Street.jpg')}}" /> 
                        <div class="content">
							<h4 class="text-uppercase m-0"><a href="#{{route('new-product-cat',193)}}"> ATV </a></h4>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[193,'Drive'])}}">ATV Drive</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[193,'Accessories'])}}">ATV Accessories</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[193,'Tools'])}}">ATV Tools</a></p>
						</div>
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
                        <img src="{{asset('frontend/img/Homepage_ATV.jpg')}}" /> 
                        <div class="content">
							<h4 class="text-uppercase m-0"><a href="{{route('new-product-cat',194)}}"> Bicycle </a></h4>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[194,'Gloves'])}}">Bicycle Gloves</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[194,'Jerseys'])}}">Bicycle Jerseys</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[194,'Pants'])}}">Bicycle Pants</a></p>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="container-fluid">
            <div class="bg-banner one py-5 px-4 text-center">
                <div class="py-2">
                    <h2 class="display-1 text-uppercase mb-4">In-Stock Now!</h2>
                    <p class="mb-4">12e & 16e STACYC E-Bikes!</p>
                    <a class="btn btn-primary" href="">Shop Now</a>
                </div>
            </div>

    </div>

	<div class="container-fluid">
            <div class="bg-banner two py-5 px-4 text-center">
                <div class="py-2">
                    <h2 class="display-1 text-uppercase mb-4">Upgrade Your Exhaust</h2>
                    <p class="mb-4">More Power For Winter</p>
					<div class="btn-div">
						<a class="btn btn-primary" href="">Shop 2-Stroke Exhaust</a>
						<a class="btn btn-primary" href="">Shop 4-Stroke Exhaust</a>
					</div>
                </div>
            </div>

    </div>

    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h2 class="display-5 text-uppercase text-center mb-5">TIRE TIME</h2>
            <div class="row mt-3 time-tire">
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
						<img src="{{asset('frontend/img/Homepage_Dirt.jpg')}}" />      
						<div class="content">
							<h4 class="text-uppercase m-0"><a href="#"> SHOP DIRT BIKE TIRES </a></h4>
						</div>	
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
                        <img src="{{asset('frontend/img/Homepage_Street.jpg')}}" /> 
                        <div class="content">
							<h4 class="text-uppercase m-0"><a href="#"> SHOP STREET BIKE TIRES </a></h4>
						</div>
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
                        <img src="{{asset('frontend/img/Homepage_ATV.jpg')}}" /> 
                        <div class="content">
							<h4 class="text-uppercase m-0"><a href="#"> SHOP ATV TIRES </a></h4>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid section-info">
            <div class="row my-3">
                <div class="col-lg-6 px-3">
                    <div class="bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/Homepage_ATV.jpg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">Up To 50% Off Alpinestars</h3>
                            <p class="mb-4">Lorem justo sit sit ipsum eos lorem kasd, kasd labore</p>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-3">
                    <div class="bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/Homepage_ATV.jpg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">40% Off! Save Up To ₹‌332,500.00</h3>
                            <p class="mb-4">Lorem justo sit sit ipsum eos lorem kasd, kasd labore</p>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                    
                    </div>
                </div>
            </div>
			
			<div class="row my-3">
                <div class="col-lg-6 px-3">
                    <div class="bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/Homepage_ATV.jpg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">Women's Riding Gear</h3>
                            <p class="mb-4">Lorem justo sit sit ipsum eos lorem kasd, kasd labore</p>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-3">
                   <div class=" bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/Homepage_ATV.jpg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">MotoSport Exclusive Brands</h3>
                            <p class="mb-4">By Gearheads, For Gearheads</p>
                            <a class="btn btn-primary py-2 px-4" href="">Read Now</a>
                        </div>
                      
                    </div>
                </div>
            </div>
		
    </div>
	    <div class="container-fluid info-banner">
	<div class="row ">
                <div class="col-lg-6 px-3">
                    <div class="align-items-center justify-content-between" style="background: #F7941D !important">
                    
                        <div class="text-center" style=" padding: 70px 0px;">
                            <h3 class="text-uppercase text-light mb-3">ALL CLEARANCE</h3>
                            <p class="mb-4">Save up to 77% On Gear & Parts</p>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-3">
                    <div class="align-items-center justify-content-between" style="background: #F7941D !important">
                        <div class="text-center" style=" padding: 70px 0px;">
                            <h3 class="text-uppercase text-light mb-3">OEM SALE</h3>
                            <p class="mb-4">Save up to 40% On Genuine Parts</p>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                      
                    </div>
                </div>
            </div>
            </div>
            <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h2 class="display-5 text-uppercase text-center mb-5">Contact Us</h2>
            <div class="row">
                <div class="col-lg-7 mb-2">
                    <div class="contact-form bg-light mb-4" style="padding: 30px;">
                        <form>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <input type="text" class="form-control p-4" placeholder="Your Name" required="required">
                                </div>
                                <div class="col-6 form-group">
                                    <input type="email" class="form-control p-4" placeholder="Your Email" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control p-4" placeholder="Subject" required="required">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control py-3 px-4" rows="5" placeholder="Message" required="required"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary py-3 px-5" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 mb-2">
                    <div class="bg-secondary d-flex flex-column justify-content-center px-5 mb-4" style="height: 435px;">
                        <div class="d-flex mb-3">
                            <i class="fa fa-3x fa-map-marker text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Head Office</h5>
                                <p>123 Street, New York, USA</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="fa fa-3x fa-map-marker text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Branch Office</h5>
                                <p>123 Street, New York, USA</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="fa fa-2x fa-envelope-open text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Customer Service</h5>
                                <p>customer@example.com</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-2x fa-envelope-open text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Return & Refund</h5>
                                <p class="m-0">refund@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

@push('styles')
    <style>
     /********** Template CSS **********/
:root {
    --primary: #bdb411;
    --secondary: #000;
    --light: #000;
    --dark: #000;
}

h1,
h2,
.font-weight-bold {
    font-weight: 700 !important;
}

h3,
h4,
.font-weight-semi-bold {
    font-weight: 600 !important;
}

h5,
h6,
.font-weight-medium {
    font-weight: 500 !important;
}

.btn-square {
    width: 36px;
    height: 36px;
}

.btn-sm-square {
    width: 28px;
    height: 28px;
}

.btn-lg-square {
    width: 46px;
    height: 46px;
}

.btn-square,
.btn-sm-square,
.btn-lg-square {
    padding-left: 0;
    padding-right: 0;
    text-align: center;
}
@media (max-width: 991.98px) {
    .navbar-dark .navbar-nav .nav-link  {
        padding: 10px 15px;
    }
}

.carousel-caption {
    top: 0;
    position: relative;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
    background: transparent;
}

@media (max-width: 576px) {
    .carousel-caption h4 {
        font-size: 18px;
        font-weight: 500 !important;
    }

    .carousel-caption h1 {
        font-size: 30px;
        font-weight: 600 !important;
    }
}

.page-header {
    height: 400px;
    margin-bottom: 90px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(rgba(28, 30, 50, .9), rgba(28, 30, 50, .9)), url({{asset('frontend/img/bg-banner.jpg')}});
    background-attachment: fixed;
}

@media (max-width: 991.98px) {
    .page-header {
        height: 300px;
    }
}

.service-item {
    height: 320px;
    background: var(--light);
    transition: .5s;
}

.service-item:hover,
.service-item.active {
    background: var(--secondary);
}

.service-item h1,
.service-item h4 {
    transition: .5s;
}

.service-item:hover h1,
.service-item.active h1 {
    color: var(--dark) !important;
}

.service-item:hover h4,
.service-item.active h4 {
    color: var(--light);
}

.rent-item {
    padding: 30px;
    text-align: center;
    background: var(--light);
    transition: .5s;
}

.rent-item:hover,
.rent-item.active {
    background: var(--secondary);
}

.rent-item h4 {
    transition: .5s;
}

.rent-item:hover h4,
.rent-item.active h4 {
    color: var(--light);
}

.team-item {
    padding: 30px 30px 0 30px;
    text-align: center;
    background: var(--light);
    transition: .5s;
}

.team-item:hover,
.owl-item.center .team-item {
    background: var(--secondary);
}

.team-item h4 {
    transition: .5s;
}

.owl-item.center .team-item h4,
.owl-item.center .rent-item h4 {
    color: var(--light);
}

.team-item .team-social {
    top: 0;
    left: 0;
    opacity: 0;
    transition: .5s;
    background: var(--light);
}

.owl-item.center .team-item .team-social,
.owl-item.center .rent-item {
    background: var(--secondary);
}

.team-item:hover .team-social {
    opacity: 1;
    background: var(--secondary);
}

.team-carousel .owl-nav,
.related-carousel .owl-nav {
    position: absolute;
    width: 100%;
    height: 60px;
    top: calc(50% - 30px);
    left: 0;
    display: flex;
    justify-content: space-between;
    z-index: 1;
}

.team-carousel .owl-nav .owl-prev,
.team-carousel .owl-nav .owl-next,
.related-carousel .owl-nav .owl-prev,
.related-carousel .owl-nav .owl-next {
    position: relative;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    background: var(--primary);
    font-size: 22px;
    transition: .5s;
}

.team-carousel .owl-nav .owl-prev:hover,
.team-carousel .owl-nav .owl-next:hover,
.related-carousel .owl-nav .owl-prev:hover,
.related-carousel .owl-nav .owl-next:hover {
    background: var(--secondary);
}

.vendor-carousel .owl-dots,
.testimonial-carousel .owl-dots {
    margin-top: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vendor-carousel .owl-dot,
.testimonial-carousel .owl-dot {
    position: relative;
    display: inline-block;
    margin: 0 5px;
    width: 20px;
    height: 20px;
    background: var(--secondary);
    transition: .5s;
}

.vendor-carousel .owl-dot.active,
.testimonial-carousel .owl-dot.active {
    width: 40px;
    height: 40px;
    background: var(--primary);
}

.testimonial-carousel .owl-item img {
    width: 80px;
    height: 80px;
}

.testimonial-carousel .owl-item .testimonial-item {
    height: 350px;
    transition: .5s;
    background: var(--light);
}

.testimonial-carousel .owl-item.center .testimonial-item {
    background: var(--secondary);
}

.testimonial-carousel .owl-item .testimonial-item h1,
.testimonial-carousel .owl-item .testimonial-item h4 {
    transition: .5s;
}

.testimonial-carousel .owl-item.center .testimonial-item h1 {
    color: var(--dark) !important;
}

.testimonial-carousel .owl-item.center .testimonial-item h4 {
    color: var(--light);
}
.bg-banner.one {
    background: url({{asset('frontend/img/bg-section-one.jpg')}});
	background-size: cover;
	padding: 80px !important
}
.bg-banner.two {
    background: url({{asset('frontend/img/bg-section-two.jpg')}});
	background-size: cover;
	padding: 80px !important
}
.btn-primary {	
    font-weight: 600;
}
.bg-banner .py-2 h2 {
    font-size: 30px;
    color: #fff !important;
}
.bg-banner .py-2 {
    background: #000000b0;
    width: 47%;
    margin: 0px auto;
    padding: 25px 0px !important;
}
.bg-banner .py-2 p {
    color: #fff;
}
.bg-banner .py-2 a.btn.btn-primary {
    background: #fff;
    color: #000;
    border-radius: 5px;
}
.bg-banner.one .py-2 {
    margin: 0px;
    text-align: left;
    padding-left: 40px !important;
}
.categories .align-items-center img, .time-tire img{
    display: block;
    width: 100%;
}
.categories .align-items-center .content {
    text-align: center;
    background: #fff;
    width: 85%;
    margin: 0px auto;
    position: relative;
    top: -45px;
    padding: 15px 0px 0px;
}
.categories .align-items-center .content a {
    color: #000;
}
.categories .align-items-center .content h4 a {
    background: #000;
    color: #fff;
    padding: 0px 15px;
    position: relative;
    top: -11px;
}
.categories .align-items-center .content p {
    line-height: 40px;
    border-bottom: 1px solid #eae6e6;
}
.time-tire .content {
    text-align: center;
    margin-top: 10px;
}
.time-tire .content a {
    color: #000;
    font-weight: 200;
}
.section-info .text-center {
    padding: 110px 0px;
    background: #00000059;
}
.section-info .text-center p {
    color: #fff;
}
.info-banner .btn-primary:hover {
    background: #000;
}
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function(){
            $(this).on('click', function(){
                for(var i=0; i<isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
         function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
    <script>
        $(document).ready(function () {
            // Set the initial page to 2
            let page = 2;
    
            // Function to hide the "Load More" button
            function hideLoadMoreButton() {
                $('#load-more').hide();
            }
    
            // Event listener for the "Load More" button
            $('#load-more').on('click', function () {
                // Make an AJAX request to fetch more products
                $.ajax({
                    url: '/load-more?page=' + page,
                    method: 'GET',
                    success: function (data) {
                        if (data.trim() === '') {
                            // No more data to load, hide the "Load More" button
                            hideLoadMoreButton();
                        } else {
                            // Append the new products to the container
                            $('#product-container').append(data);
    
                            // Increment the page for the next request
                            page++;
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    

@endpush
