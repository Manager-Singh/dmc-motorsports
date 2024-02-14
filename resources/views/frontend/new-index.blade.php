@extends('frontend.layouts.master')
@section('title','DMC Motorsports || HOME PAGE')
@section('main-content')

   

	

    <div class="container-fluid bg-white pt-3 px-lg-5" style="background: #ededed !important;">
        
    @include('frontend.partials.search')
    </div>

    <div class="container-fluid p-0" >
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
            @foreach($banners as $key=>$banner)
                <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                    <img class="w-100" src="{{$banner->photo}}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;display:none;">
                        @if($banner->title)
							<h2 class="display-1mb-md-4">{{$banner->title}}</h2>
                            @endif
                            @if($banner->description)
                            <p class="text-uppercase mb-md-3">{!! html_entity_decode($banner->description) !!}</p>  
                            @endif
                            @if($banner->title)                         
                            <a href="{{route('product-grids')}}" class="btn btn-primary mt-2">Shop Now</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
 
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
            <div class="row mt-3">                
                <ul class="partner-logo">
					<li><a href=""><img src="{{asset('frontend/img/partner-logo-1.png')}}" /></a></li>
					<li><a href=""><img src="{{asset('frontend/img/partner-logo-2.jpg')}}" /></a></li>
					<li><a href=""><img src="{{asset('frontend/img/partner-logo-3.png')}}" /></a></li>
					<li><a href=""><img src="{{asset('frontend/img/partner-logo-4.png')}}" /></a></li>
					<li><a href=""><img src="{{asset('frontend/img/partner-logo-5.png')}}" /></a></li>
					<li><a href=""><img src="{{asset('frontend/img/partner-logo-6.png')}}" /></a></li>
					<li><a href=""><img src="{{asset('frontend/img/partner-logo-7.png')}}" /></a></li>
				
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
						<img src="{{asset('frontend/img/home-categories-apperal.png')}}" />      
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
                        <img src="{{asset('frontend/img/home-categories-atv.jpg')}}" /> 
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
                        <img src="{{asset('frontend/img/home-categories-offroad.jpg')}}" /> 
                        <div class="content">
							<h4 class="text-uppercase m-0"><a href="{{route('new-product-cat',197)}}"> Offroad </a></h4>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[197,'Brakes'])}}">Offroad Brakes</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[197,'Engine'])}}">Offroad Engine</a></p>
							<p class="text-uppercase m-0"><a href="{{route('product-types-by-cat',[197,'Tools'])}}">Offroad Tools</a></p>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!--div class="container-fluid">
            <div class="bg-banner one py-5 px-4 text-center">
                <div class="py-2">
                    <h2 class="display-1 text-uppercase mb-4">E-Bikes</h2>
                    <p class="mb-4">12e & 16e STACYC E-Bikes!</p>
                    <a class="btn btn-primary" href="">Shop Now</a>
                </div>
            </div>

    </div-->
	
	<div class="container-fluid p-0">
        <div id="e-bike-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{asset('frontend/img/e-bike-slider-one.png')}}" alt="Image">
                    <div class="carousel-caption e-bike d-flex flex-column bg-banner">
                        <div class="py-2">
							<h2 class="display-1 text-uppercase mb-4">E-Bikes</h2>
							<p class="mb-4">12e & 16e STACYC E-Bikes!</p>
							<a class="btn btn-primary" href="">Shop Now</a>
						</div>
                    </div>
                </div>
				<div class="carousel-item">
                    <img class="w-100" src="{{asset('frontend/img/e-bike-slider-two.png')}}" alt="Image">
                    <div class="carousel-caption e-bike d-flex flex-column bg-banner">
                        <div class="py-2">
							<h2 class="display-1 text-uppercase mb-4">E-Bikes</h2>
							<p class="mb-4">12e & 16e STACYC E-Bikes!</p>
							<a class="btn btn-primary" href="">Shop Now</a>
						</div>
                    </div>
                </div>
				<div class="carousel-item">
                    <img class="w-100" src="{{asset('frontend/img/e-bike-slider-three.png')}}" alt="Image">
                    <div class="carousel-caption e-bike d-flex flex-column bg-banner">
                        <div class="py-2">
							<h2 class="display-1 text-uppercase mb-4">E-Bikes</h2>
							<p class="mb-4">12e & 16e STACYC E-Bikes!</p>
							<a class="btn btn-primary" href="">Shop Now</a>
						</div>
                    </div>
                </div>
				<div class="carousel-item">
                    <img class="w-100" src="{{asset('frontend/img/e-bike-slider-four.png')}}" alt="Image">
                    <div class="carousel-caption e-bike d-flex flex-column bg-banner">
                        <div class="py-2">
							<h2 class="display-1 text-uppercase mb-4">E-Bikes</h2>
							<p class="mb-4">12e & 16e STACYC E-Bikes!</p>
							<a class="btn btn-primary" href="">Shop Now</a>
						</div>
                    </div>
                </div>
 
            </div>
            <a class="carousel-control-prev" href="#e-bike-carousel" data-slide="prev">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#e-bike-carousel" data-slide="next">
                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>


	<div class="container-fluid mt-4">
            <div class="bg-banner two py-5 px-4 text-center">
                <div class="py-2">
                    <h2 class="display-1 text-uppercase mb-4">DMC Motorsports Exclusive Products</h2>
                    <p class="mb-4">More Power For Winter</p>
					<div class="btn-div">
						<a class="btn btn-primary" href="https://dmc-motorsports.com/products/197/Exhaust">Shop 2-Stroke Exhaust</a>
					</div>
                </div>
            </div>

    </div>

    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <h2 class="display-5 text-uppercase text-center mb-5">TIRE FINDER</h2>
            <div class="row mt-3 time-tire">
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
					<a href="https://dmc-motorsports.com/products/197/Tires">
						<img src="{{asset('frontend/img/TIRE-dirtbike-tire.jpg')}}" />      
						<div class="content">
							<h4 class="text-uppercase m-0"><a href="https://dmc-motorsports.com/products/197/Tires"> SHOP DIRT BIKE TIRES </a></h4>
						</div>
					</a>
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
					<a href="https://dmc-motorsports.com/products/199/Tires">
                        <img src="{{asset('frontend/img/TIRE-street-tire.png')}}" /> 
                        <div class="content">
							<h4 class="text-uppercase m-0"><a href="https://dmc-motorsports.com/products/199/Tires"> SHOP STREET BIKE TIRES </a></h4>
						</div>
					</a>	
                    </div>
                </div>
                <div class="col-lg-4 mb-2">
                    <div class="align-items-center">
					<a href="https://dmc-motorsports.com/products/193/Tires">
                        <img src="{{asset('frontend/img/TIRE-atv-tire.jpg')}}" /> 
                        <div class="content">
							<h4 class="text-uppercase m-0"><a href="https://dmc-motorsports.com/products/193/Tires"> SHOP ATV TIRES </a></h4>
						</div>
					</a>	
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid section-info">
            <div class="row my-3">
                <div class="col-lg-6 px-3">
                    <div class="bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/upto50per.jpeg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">Helmets Up To 50% Off</h3>
                            <a class="btn btn-primary py-2 px-4" href="https://dmc-motorsports.com/product-category/192">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-3">
                    <div class="bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/40peroff.jpeg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">All Things Wheels</h3>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                    
                    </div>
                </div>
            </div>
			
			<div class="row my-3">
                <div class="col-lg-6 px-3">
                    <div class="bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/suspension-selection.jpg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">The Best Suspension Period</h3>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-3">
                   <div class=" bg-secondary align-items-center justify-content-between" style="background:url({{asset('frontend/img/yoshi-exhuast-selection.jpg')}});background-size: cover;">
                       
                        <div class="text-center">
                            <h3 class="text-uppercase text-light mb-3">Shop Upgraded Exhaust Systems</h3>
                            <a class="btn btn-primary py-2 px-4" href="">Shop Now</a>
                        </div>
                      
                    </div>
                </div>
            </div>
		
    </div>
	    <div class="container-fluid info-banner">
	<div class="row ">
                <div class="col-lg-6 px-3">
                    <div class="align-items-center justify-content-between" style="background:url({{asset('frontend/img/clearance-fly-pic.png')}});background-size: cover;background-color: #00000042;background-blend-mode: multiply;">
                    
                        <div class="text-center" style=" padding: 70px 0px;">
                            <h3 class="text-uppercase text-light mb-3">ALL CLEARANCE</h3>
                            <p class="mb-4">Save up to 77% On Gear & Parts</p>
                            <a class="btn btn-primary py-2 px-4" href="https://dmc-motorsports.com/product-grids">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 px-3">
                    <div class="align-items-center justify-content-between" style="background:url({{asset('frontend/img/new-products-pic.jpeg')}});background-size: cover;background-color: #00000042;background-blend-mode: multiply;">
                        <div class="text-center" style=" padding: 70px 0px;">
                            <h3 class="text-uppercase text-light mb-3">New Products</h3>
                            <p class="mb-4">Save up to 40% On Genuine Parts</p>
                            <a class="btn btn-primary py-2 px-4" href="https://dmc-motorsports.com/product-grids">Shop Now</a>
                        </div>
                      
                    </div>
                </div>
            </div>
            </div>
			
	
	<div class="container-fluid pt-4 mt-5">
        <div class="container pb-3">
            <h2 class="display-5 text-uppercase text-center mb-5"> Shop our selection of parts and gear </h2>
            <div class="row mt-3 shop-parts">
                <div class="col-lg-3 mb-2">
                    <div class="align-items-center">
						<h4> <a href=""> Parts </a> </h4>
						<ul> 
							<li><a href="body">Body</a></li>
							<li><a href="engine">Engine</a></li>
							<li><a href="exhaust">Exhaust</a></li>
							<li><a href="drive">Drive</a></li>
							<li><a href="intake">Intake</a></li>
							<li><a href="controls">Controls</a></li>
							<li><a href="brakes">Brakes</a></li>
							<li><a href="fuel-system">Fuel System</a></li>
							<li><a href="graphics">Graphics</a></li>
							<li><a href="tires">Tires</a></li>
							<li><a href="suspension">Suspension</a></li>
							<li><a href="crash-protection">Crash Protection</a></li>
							<li><a href="lights-and-electrical">Lights and Electrical</a></li>
							<li><a href="windscreens-and-accessories">Windscreens and Accessories</a></li> 
							<li><a href="windshields-and-accessories">Windshields and Accessories</a></li>
							<li><a href="farming-and-hunting">Farming and Hunting</a></li> 
							<li><a href="winch-and-plow">Winch and Plow</a></li> 
							<li><a href="luggage-and-racks">Luggage and Racks</a></li>
							<li><a href="wheels-and-rims">Wheels and Rims</a></li> 
						</ul>
                    </div>
                </div>
                <div class="col-lg-3 mb-2">
                    <div class="align-items-center">
                        <h4> <a href=""> Tires </a> </h4>
						<ul> 
							<li><a href="/motorcycle/tire-combos">Tire Combos</a></li> 
							<li><a href="/motorcycle/tires">Tires</a></li> 
							<li><a href="/motorcycle/wheels">Wheels</a></li> 
							<li><a href="/motorcycle/tire-and-wheel-accessories">Tire and Wheel Accessories</a></li> 
							<li><a href="/motorcycle/tire-care">Tire Care</a></li>
						</ul>
                    </div>
                </div>
                <div class="col-lg-3 mb-2">
                    <div class="align-items-center">
                        <h4> <a href=""> Riding Gear </a> </h4>
						<ul> 
							<li><a href="pants-jersey-glove-combos">Pants Jersey Glove Combos</a></li>
							<li><a href="pants">Pants</a></li> 
							<li><a href="jackets">Jackets</a></li>
							<li><a href="boots">Boots</a></li> 
							<li><a href="jerseys">Jerseys</a></li> 
							<li><a href="gloves">Gloves</a></li> 
							<li><a href="helmets">Helmets</a></li>
							<li><a href="goggles-and-accessories">Goggles and Accessories</a></li>
							<li><a href="protection">Protection</a></li>
							<li><a href="bags">Bags</a></li> 
							<li><a href="race-suits">Race Suits</a></li>
							<li><a href="riding-vests">Riding Vests</a></li>
							<li><a href="snow-bike-gear">Snow Bike Gear</a></li> 
							<li><a href="heated-riding-gear">Heated Riding Gear</a></li>
							<li><a href="rain-gear">Rain Gear</a></li> 
							<li><a href="/motorcycle/health-and-fitness">Health and Fitness</a></li>
							<li><a href="womens-riding-gear">Womens Riding Gear</a></li> 
						</ul>
                    </div>
                </div>
				<div class="col-lg-3 mb-2">
                    <div class="align-items-center">
                        <h4> <a href=""> Helmets </a> </h4>
						<ul> 
							<li><a href="off-road-helmets">Off Road Helmets</a></li>
							<li><a href="full-face-helmets">Full Face Helmets</a></li> 
							<li><a href="dual-sport-helmets">Dual Sport Helmets</a></li>
							<li><a href="modular-helmets">Modular Helmets</a></li>
							<li><a href="open-face-helmets">Open Face Helmets</a></li>
							<li><a href="half-shell-helmets">Half Shell Helmets</a></li> 
							<li><a href="snell-helmets">Snell Helmets</a></li>
							<li><a href="helmet-cameras">Helmet Cameras</a></li>
							<li><a href="communicators-and-accessories">Communicators and Accessories</a></li>
							<li><a href="helmet-accessories">Helmet Accessories</a></li> 
							<li><a href="visors-and-shields">Visors and Shields</a></li>
						</ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
       <div class="container-fluid bg-light pt-4">
        <div class="container">
            <h2 class="display-5 text-uppercase text-center mb-3">Contact Us</h2>
            <div class="row">
                <div class="col-lg-7 mb-2">
                    <div class="contact-form mb-4" style="padding: 30px;">
                   
                        <form class="form-contact form contact_form" method="post" action="{{route('contact.store')}}" id="contactForm" novalidate="novalidate">
                            @csrf
                            <div class="row">
                                <div class="col-6 form-group">
                                    <input type="text" class="form-control p-4" placeholder="Your Name" name="name" required="required">
                                </div>
                                <div class="col-6 form-group">
                                    <input type="email"  name="email" class="form-control p-4" placeholder="Your Email" required="required">
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-6 form-group">
                                <input type="text" name="subject" class="form-control p-4" placeholder="Subject" required="required">
                            </div>
                            <div class="col-6 form-group">
                                    <input type="number"  name="phone" class="form-control p-4" placeholder="Your Phone" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control py-3 px-4" name="message" rows="5" placeholder="Message" required="required"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary py-3 px-5" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                @php
								$settings=DB::table('settings')->get();
								
							@endphp
                <div class="col-lg-5 mb-2">
                    <div class="bg-secondary d-flex flex-column justify-content-center px-5 mb-4" style="height: 435px;">
                        <div class="d-flex mb-3">
                            <i class="fa fa-3x fa-map-marker text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Store Location</h5>
                                <p> @foreach($settings as $data) {{$data->address}} @endforeach</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="fa fa-3x fa-phone text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Store Contact</h5>
                                <p>@foreach($settings as $data) {{$data->phone}} @endforeach</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-2x fa-envelope-open text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Customer Service</h5>
                                <p>@foreach($settings as $data) {{$data->email}} @endforeach</p>
                            </div>
                        </div>
                        <!-- <div class="d-flex">
                            <i class="fa fa-2x fa-envelope-open text-primary flex-shrink-0 mr-3"></i>
                            <div class="mt-n1">
                                <h5 class="text-light">Return & Refund</h5>
                                <p class="m-0">info@dmc-motorsports.com</p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-success">Thank you!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-success">Your message is successfully sent...</p>
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Modals error -->
	<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-warning">Sorry!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-warning">Something went wrong.</p>
			</div>
		  </div>
		</div>
	</div>
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

.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
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
    background: url({{asset('frontend/img/stock-section.jpeg')}});
	background-size: cover;
	padding: 80px !important
}
.bg-banner.two {
    background: url({{asset('frontend/img/upgrade-section.jpeg')}});
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
.time-tire img {
    height: 300px;
}
ul.partner-logo img {
    padding: 0px 20px;
}
.categories img {
    height: 330px;
    object-fit: cover;
}
.carousel-caption.e-bike {
    position: absolute;
    top: 149px;
    padding: 0px !important;
    left: 12% !important;
}
.carousel-caption.e-bike.bg-banner .py-2 {
    background: #000000b0;
    width: 40%;
    margin: 0px;
    padding: 25px 0px !important;
}
ul.partner-logo img {
    width: 180px;
    height: 50px;
    object-fit: scale-down;
}
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
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
