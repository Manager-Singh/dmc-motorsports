@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Order       <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>S.N.</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Quantity</th>
            <th>Charge</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->order_number}}</td>
            <td>{{$order->first_name}} {{$order->last_name}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->quantity}}</td>
                      @if(isset($order->shipping))
                        <td>${{@$order->shipping->price}}</td>
                        @else
                        <td>Free</td>
                        @endif
            <td>${{number_format($order->total_amount,2)}}</td>
            <td>
                @if($order->status=='new')
                  <span class="badge badge-primary">{{$order->status}}</span>
                @elseif($order->status=='process')
                  <span class="badge badge-warning">{{$order->status}}</span>
                @elseif($order->status=='delivered')
                  <span class="badge badge-success">{{$order->status}}</span>
                @else
                  <span class="badge badge-danger">{{$order->status}}</span>
                @endif
            </td>
            <td>
                <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                  @csrf
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>

        </tr>
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">ORDER INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Order Number</td>
                        <td> : {{$order->order_number}}</td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td> : {{$order->quantity}}</td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td> : {{$order->status}}</td>
                    </tr>
                    <tr>
                        <td>Tracking Number</td>
                        <td> : {{$order->tracking_number}}</td>
                    </tr>
                    <tr>
                        <td>Tracking Url</td>
                        <td> : {{$order->tracking_url}}</td>
                    </tr>
                    <tr>
                        <td>Shipping Charge</td>
                        
                        @if(isset($order->shipping))
                        <td> :${{@$order->shipping->price}}</td>
                        @else
                        <td> : Free</td>
                        @endif
                    </tr> 
                    <tr>
                      <td>Coupon</td>
                      <td> : $ {{number_format($order->coupon,2)}}</td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td> : $ {{number_format($order->total_amount,2)}}</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td> : @if($order->payment_method=='cod') Cash on Delivery @elseif($order->payment_method=='stripe') Stripe @else Paypal @endif</td>
                    </tr>
                    @if($order->payment_method=='stripe' && $order->payment_status=='paid')
                    <tr>
                        <td>Tranction ID</td>
                        <td> : {{$order->transaction_id}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Payment Status</td>
                        <td> : {{$order->payment_status}}</td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Full Name</td>
                        <td> : {{$order->first_name}} {{$order->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$order->email}}</td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td> : {{$order->phone}}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td> : {{$order->address1}}, {{$order->address2}}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td> : {{$order->country}}</td>
                    </tr>
                    <tr>
                        <td>Post Code</td>
                        <td> : {{$order->post_code}}</td>
                    </tr>
              </table>
            </div>
          </div>
          <div class="col-lg-12">
          @php
             // print_r($order->cart_info);
          @endphp
          <h4 class="text-center pb-4">ITEMS INFORMATION</h4>
          <table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>PRODUCT</th>
								<th>NAME</th>
								<th class="text-center">UNIT PRICE</th>
								<th class="text-center">QUANTITY</th>
								<th class="text-center">TOTAL</th>
							</tr>
						</thead>

            <tbody id="cart_item_list">
							
                @foreach($order->cart_info as $cart)
                @php
                      //print_r($cart->product->images);
                      //die;
                @endphp
										<tr>
											@if(isset($cart->product->images) && isset($cart->product->images[0]))
											@if($cart->product->images[0]->domain == 'dmc-motorsports.com')
											@php
											$fimg_url = 'https://'.$cart->product->images[0]->domain.$cart->product->images[0]->path.'/'.$cart->product->images[0]->filename;
											@endphp
											@else
											@php
											$fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$cart->product->images[0]->filename;
											@endphp
											@endif
											@endif
											<td class="image" data-title="No"><img src="{{$fimg_url}}" alt="{{$fimg_url}}" width="200" height="150"></td>
											<td class="product-des" data-title="Description">
												<p class="product-name"><a href="{{route('product-detail',$cart->product->slug)}}" target="_blank">{{$cart->product->name}}</a></p>
												<p class="product-brand"><span>Brand:</span> {{$cart->product->brand->title}}</p>
												<p class="product-sku"><span>SKU:</span> {{$cart->product->sku}}</p>
											</td>
											<td class="price" data-title="Price"><span>${{number_format($cart['price'],2)}}</span></td>
											<td class="qty" data-title="Qty"><!-- Input Order -->
                      {{$cart->quantity}}
												<!--/ End Input Order -->
											</td>
											<td class="total-amount cart_single_price" data-title="Total"><span class="money">${{$cart['amount']}}</span></td>

										
										</tr>
									@endforeach
						</tbody>
					</table>
          
          </div>
        </div>
      </div>
    </section>
    
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
