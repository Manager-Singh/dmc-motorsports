@extends('frontend.layouts.master')

@section('title','E-SHOP || About Us')

@section('main-content')

	<!-- Breadcrumbs -->
	
	<div class="container">
		<div class="content-box mt-5">
			<h4>Shipping and Returns Policy</h4>
			<h5>Shipping Information:</h5>
			<p><strong>Order Processing:</strong></p>
			<ul>
				<li>Orders are typically processed within 1-2 business days.</li>
				<li>Orders placed during weekends or holidays will be processed on the following business day.</li>
			</ul>
			<p><strong>Shipping Methods:</strong></p>
			<ul>
				<li>We offer various shipping options during checkout.</li>
				<li>Shipping costs and estimated delivery times are provided for your convenience.</li>
			</ul>
			<p><strong>Shipping Address:</strong></p>
			<ul>
				<li>Please ensure that the shipping address provided during checkout is accurate.</li>
				<li>DMC Motorsports is not responsible for delays or issues caused by incorrect addresses.</li>
			</ul>
			<p><strong>Tracking Information:</strong></p>
			<ul>
				<li>Once your order is shipped, you will receive a confirmation email with tracking information.</li>
				<li>You can use this information to track your package's delivery status.</li>
			</ul>
			<p><strong>Lost or Stolen Packages:</strong></p>
			<ul>
				<li>DMC Motorsports is not liable for lost or stolen packages after they have been shipped.</li>
				<li>If you encounter issues with delivery, please contact the shipping carrier.</li>
			</ul>
			
			<h5>Returns and Exchanges:</h5>
			<p><strong>Return Eligibility:</strong></p>
			<ul>
				<li>To be eligible for a return, the item must be unused and in the same condition as received.</li>
				<li>Returns must be initiated within 30 days of the purchase date.</li>
			</ul>
			<p><strong>Return Process:</strong></p>
			<ul>
				<li>To initiate a return, please contact our customer service at [contact@dmc-motorsports.com].</li>
				<li>Provide your order number and a brief explanation of the reason for the return.</li>
			</ul>
			<p><strong>Refund or Exchange:</strong></p>
			<ul>
				<li>Once your return is received and inspected, we will notify you of the approval or rejection of your refund or exchange.</li>
				<li>Refunds will be processed to the original method of payment.</li>
			</ul>
			<p><strong>Return Shipping:</strong></p>
			<ul>
				<li>Customers are responsible for return shipping costs unless the return is due to an error on our part.</li>
				<li>Consider using a trackable shipping service for returns.</li>
			</ul>
			<p><strong>Damaged or Defective Items:</strong></p>
			<ul>
				<li>If you receive a damaged or defective item, please contact us immediately for assistance.</li>
			</ul>
			
			<h5>Important Note:</h5>
			<ul>
				<li>DMC Motorsports is not liable for shipped goods after they have been dispatched. Once a package is handed over to the shipping carrier, the responsibility for its delivery rests with them.</li>
			</ul>
			<p>For any further inquiries or assistance, please contact us at</p>
			<p><strong>[contact@dmc-motorsports.com].
</strong></p>
		
		</div>
	</div>
	<!-- End Shop Services Area -->

	@include('frontend.layouts.newsletter')
@endsection
