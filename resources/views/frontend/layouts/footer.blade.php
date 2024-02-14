
	<!-- Start Footer Area -->
	<footer class="footer">
	@php
								$settings=DB::table('settings')->get();
								
							@endphp
	 <!-- Footer Start -->
	 <div class="container-fluid bg-secondary py-5 px-sm-3 px-md-5 footer">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Get In Touch</h4>
                <p class="mb-2"><i class="fa fa-map-marker text-white mr-3"></i>@foreach($settings as $data) {{$data->address}} @endforeach</p>
                <p class="mb-2"><i class="fa fa-phone text-white mr-3"></i>@foreach($settings as $data) {{$data->phone}} @endforeach</p>
                <p><i class="fa fa-envelope text-white mr-3"></i>@foreach($settings as $data) {{$data->email}} @endforeach</p>
				
                <h6 class="text-uppercase text-white py-2">Follow Us</h6>
                <div class="d-flex justify-content-start footer-social">
                    {{-- <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fa fa-twitter"></i></a> --}}
                    <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="https://www.facebook.com/DMCMotorsports14/"><i class="fa fa-facebook-f"></i></a>
                    {{-- <a class="btn btn-lg btn-dark btn-lg-square mr-2" href="#"><i class="fa fa-linkedin"></i></a> --}}
                    <a class="btn btn-lg btn-dark btn-lg-square" href="https://www.instagram.com/dmc_motorsports/"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Usefull Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <!-- <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Private Policy</a> -->
                    <a class="text-body mb-2" href="/term-and-conditions"><i class="fa fa-angle-right text-white mr-2"></i>Term & Conditions</a>
                    <a class="text-body mb-2" href="/user/register"><i class="fa fa-angle-right text-white mr-2"></i>New Member Registration</a>
                    <!-- <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Affiliate Programme</a> -->
                    <a class="text-body mb-2" href="/return-and-refund"><i class="fa fa-angle-right text-white mr-2"></i>Return & Refund</a>
                    <a class="text-body" href="/help"><i class="fa fa-angle-right text-white mr-2"></i>Help & FQAs</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Customer Service</h4>
                <div class="d-flex flex-column justify-content-start">
                    <!-- <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Payment Methods</a> -->
                    <!-- <a class="text-body mb-2" href="/moneyback"><i class="fa fa-angle-right text-white mr-2"></i>Money-back</a> -->
                    <!-- <a class="text-body mb-2" href="#"><i class="fa fa-angle-right text-white mr-2"></i>Returns</a> -->
                    <a class="text-body mb-2" href="/shipping-return-policy"><i class="fa fa-angle-right text-white mr-2"></i>Shipping & Returns Policy</a>
                    <a class="text-body mb-2" href="/privacy-policy"><i class="fa fa-angle-right text-white mr-2"></i>Privacy Policy</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-uppercase text-light mb-4">Newsletter</h4>
                <p class="mb-4">Volup amet magna clita tempor. Tempor sea eos vero ipsum. Lorem lorem sit sed elitr sed kasd et</p>
                <div class="w-100 mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-light" style="padding: 0px 15px;" placeholder="Your Email">
                        <div class="input-group-append">
                            <button class="btn btn-primary text-uppercase px-3">Sign Up</button>
                        </div>
                    </div>
                </div>
                <i>Lorem sit sed elitr sed kasd et</i>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark py-4 px-sm-3 px-md-5"> 
		<p class="mb-2 text-center copyright">Copyright © {{date('Y')}} <a href="https://dmc-motorsports.com/" target="_blank">DMC Motorsports.com</a>  -  All Rights Reserved.</p>
    </div>
    <!-- Footer End -->
		
	<style>
	#st-2.st-right {
		display: none;
	}
	</style>
	
 
	<!-- Jquery -->
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{asset('frontend/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/js/easing.js')}}"></script>

	<!-- Active JS -->
	<script src="{{asset('frontend/js/active.js')}}"></script>

	
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
			$('#product_category').change(function() {
				$("#product_brand option:selected").prop("selected", false);
				$("#product_type option:selected").prop("selected", false);
				var parentForm = $(this).closest("form");
				if (parentForm && parentForm.length > 0)
				parentForm.submit();
			});
			$('#product_brand').change(function() {
				// $("#product_brand option:selected").prop("selected", false);
				$("#product_type option:selected").prop("selected", false);
				var parentForm = $(this).closest("form");
				if (parentForm && parentForm.length > 0)
				parentForm.submit();
			});
			$('#product_type').change(function() {
				// $("#product_brand option:selected").prop("selected", false);
				// $("#product_type option:selected").prop("selected", false);
				var parentForm = $(this).closest("form");
				if (parentForm && parentForm.length > 0)
				parentForm.submit();
			});
		});
	  </script>