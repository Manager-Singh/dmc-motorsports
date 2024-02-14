@extends('frontend.layouts.master')

@section('title','E-SHOP || Order Track Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Order Track</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
<section class="tracking_box_area section_gap py-5">
    <div class="container">
        <div class="tracking_box_inner">
            <p>To track your order please enter your Order ID in the box below and press the "Track" button. This was given
                to you on your receipt and in the confirmation email you should have received.</p>
            <form class="row tracking_form my-4" action="{{route('product.track.order')}}" method="get" novalidate="novalidate">
              
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control p-2"  name="order_number" placeholder="Enter your order number">
                </div>
                <div class="col-md-8 form-group">
                    <button type="submit" value="submit" class="btn submit_btn">Track Order</button>
                </div>
            </form>
        </div>
        @if(isset($order))
            <div class="tracking_box_inner tracking-info">
                <h4>Tracking Info</h4>
            
                    <p><strong>Order Number : </strong>{{$order->order_number}}</p>
                @if($order->status=="new")
                    <p><strong>Order Status : </strong>Your order has been placed. please wait.</p>
                
                @elseif($order->status=="process")
                    <p><strong>Order Status : </strong>Your order is under processing please wait.</p>
                    @if(isset($order->tracking_number))
                        <p><strong>Order Tracking Number : </strong>{{$order->tracking_number}}</p>
                    @endif
                    @if(isset($order->tracking_url))
                        <p><strong>Order Tracking Url : </strong><a href="{{$order->tracking_url}}" target="_blank">Click Here</a></p>
                    @endif
                
                @elseif($order->status=="delivered")
                    <p><strong>Order Status : </strong>Your order is successfully delivered.</p>
                @else
                    <p><strong>Order Status : </strong>Your order canceled. please try again</p>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
@push('styles')
  <style>
     .tracking-info {
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .tracking-info h4 {
        text-align: center;
        background: #ccc;
        padding: 8px;
        color: #1625ff;
    }
    .tracking-info p {
        border-bottom: 1px solid #ccc;
        margin-bottom: 7px;
        margin-top: 6px;
        padding-bottom: 6px;
        padding-left: 12px;
    }
    .tracking-info p:last-child {
        border: none;
    }
    .tracking-info p a {
        color: #2c2afb;
    }
  </style>
@endpush

