@extends('frontend.layouts.master')

@section('title','E-SHOP || PRODUCT PAGE')

@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="#">{{$category->title}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Product Types</h1>
                        </div>
                    </div>
                </div>
                <div class="row" id="product-container">
                    
                    @foreach($attributevalues as $attributevalue)
                    @php
                    $count = Helper::getItemCount($category->wps_id,$attributevalue->name);
                    @endphp
                    @if($count>0)
                        <div class="col-md-4">
                            <!-- Start Single List  -->
                            <div class="single-list">
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('product-types-by-cat',[$category->wps_id,$attributevalue->name])}}">{{$attributevalue->name}}</a></h4>
                                    </div>
                                
                            </div>
                            <!-- End Single List  -->
                        </div>
                        @endif
                    @endforeach

            </div>
           
        </div>
        </div>
    </div>
</section>

  



 

@endsection
@push('styles')
<style>
    .pagination{
        display:inline-flex;
    }
    .filter_button{
        /* height:20px; */
        text-align: center;
        background:#F7941D;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
</style>
@endpush
@push('scripts')

@endpush
