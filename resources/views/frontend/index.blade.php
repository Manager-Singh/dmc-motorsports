@extends('frontend.layouts.master')
@section('title','E-SHOP || HOME PAGE')
@section('main-content')
<!-- Slider Area -->
@if(count($banners)>0)
    <section id="Gslider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
            @endforeach

        </ol>
        <div class="carousel-inner" role="listbox">
                @foreach($banners as $key=>$banner)
                <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                    <img class="first-slide" src="{{$banner->photo}}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block text-left">
                        <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                        <p>{!! html_entity_decode($banner->description) !!}</p>
                        <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">Shop Now<i class="far fa-arrow-alt-circle-right"></i></i></a>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
    </section>
@endif

<!--/ End Slider Area -->
<!-- Start Search Area -->
<section class="search-section section">
    <div class="container">
        <div class="row">
            <form action="{{route('search.items')}}" class="search-vehicle-form" method="POST" >
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="carMaker">Select Vehicle Maker</label>
                        <select name="vehicle_maker" formcontrolname="carMaker" class="form-control" id="carMaker">
                            <option value="">Select Car Maker</option>
                            
                            @foreach($vehiclemakes as $wps=>$vehiclemake)
                            <option value="{{$wps}}">{{$vehiclemake}}</option>
                            @endforeach
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="modelLine">Select Vehicle Model</label>
                        <select name="vehicle_model" formcontrolname="modelLine" class="form-control" id="modelLine" disabled='disabled'>
                            <option value="0: null">Select Model Line</option>
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
        
                    <div class="form-group col-md-2">
                        <label for="vehicle-year">Select Vehicle Year</label>
                        <select name="vehicle_year" formcontrolname="vehicle-year" class="form-control" id="vehicle-year"  disabled='disabled'>
                            <option value="0: null">Select Year</option>
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary" id="search-items" disabled='disabled'>Search Items</button>
                </div>
            </form>
        </div>
    </div>
</section>
<!--/ End Search Area -->
<!-- Start Small Banner  -->
<section class="small-banner section">
    <div class="container-fluid">
        <div class="row">
           
            @if($category_banner_lists)
                @foreach($category_banner_lists as $cat)
                    @if($cat->is_parent==1)
                        <!-- Single Banner  -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-banner">
                                @if($cat->photo)
                                <img src="{{$cat->photo}}" alt="{{$cat->photo}}">
                            @else
                                
                            
                                @if(isset($cat->images))
                                        @php
                                            // $photo=explode(',',$cat->photo);
                                            // // dd($photo);
                                            $f_item_image = $cat->images->image;
                              // print_r($f_item_image);
                                $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$f_item_image->filename;
                                            
                                        @endphp
                                        @else
                                        @php
                                        $fimg_url = 'backend/img/thumbnail-default.jpg';
                                        @endphp
                                         @endif
                                    <img src="{{$fimg_url}}" alt="#">
                                    @endif
                                <div class="content">
                                    <h3>{{$cat->title}}</h3>
                                        <a href="{{route('product-cat',$cat->slug)}}">Discover Now</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- /End Single Banner  -->
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- End Midium Banner -->
<!-- Start Shop Home List  -->
<section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Main Categories</h1>
                        </div>
                    </div>
                </div>
                <div class="row" id="product-container">
                    
                    @foreach($all_category_lists as $cat)
                        <div class="col-md-4">
                            <!-- Start Single List  -->
                            <div class="single-list">
                                <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="list-image overlay">
                                        @if($cat->photo)
                                        <img src="{{$cat->photo}}" alt="{{$cat->photo}}">
                                    @else
                                        
                                    
                                        @if(isset($cat->images))
                                                @php
                                                    // $photo=explode(',',$cat->photo);
                                                    // // dd($photo);
                                                    $f_item_image = $cat->images->image;
                                      // print_r($f_item_image);
                                        $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$f_item_image->filename;
                                                    
                                                @endphp
                                                @else
                                                @php
                                                $fimg_url = 'backend/img/thumbnail-default.jpg';
                                                @endphp
                                                 @endif
                                            <img src="{{$fimg_url}}" alt="#">
                                            @endif
                                        <a href="{{route('add-to-cart',$cat->wps_id)}}" class="buy"><i class="fa fa-eye"></i></a>
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 no-padding">
                                    <div class="content">
                                        <h4 class="title"><a href="{{route('add-to-cart',$cat->wps_id)}}">{{$cat->title}}</a></h4>
                                        {{-- <p class="price with-discount">${{number_format($product->discount,2)}}</p> --}}
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- End Single List  -->
                        </div>
                    @endforeach

            </div>
            <div class="row">
                <button class="btn" id="load-more">Load More</button>
            </div>
        </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->
<section class="shop-blog section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>From Our Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @if($posts)
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Single Blog  -->
                        <div class="shop-single-blog">
                            <img src="{{$post->photo}}" alt="{{$post->photo}}">
                            <div class="content">
                                <p class="date">{{$post->created_at->format('d M , Y. D')}}</p>
                                <a href="{{route('blog.detail',$post->slug)}}" class="title">{{$post->title}}</a>
                                <a href="{{route('blog.detail',$post->slug)}}" class="more-btn">Continue Reading</a>
                            </div>
                        </div>
                        <!-- End Single Blog  -->
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
<!-- End Shop Blog  -->

<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Free shiping</h4>
                    <p>Orders over $100</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 30 days returns</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Sucure Payment</h4>
                    <p>100% secure payment</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Best Peice</h4>
                    <p>Guaranteed price</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->

@include('frontend.layouts.newsletter')

<!-- Modal -->
@if($product_lists)
    @foreach($product_lists as $key=>$product)
        <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                        <div class="product-gallery">
                                            <div class="quickview-slider-active">
                                                @php
                                                    $photo=explode(',',$product->photo);
                                                // dd($photo);
                                                @endphp
                                                @foreach($photo as $data)
                                                    <div class="single-slider">
                                                        <img src="{{$data}}" alt="{{$data}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{$product->name}}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    {{-- <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="fa fa-star"></i> --}}
                                                    @php
                                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                    @endphp
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($rate>=$i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                        <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{$rate_count}} customer review)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if($product->stock >0)
                                                <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                @else
                                                <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <h3><small><del class="text-muted">${{number_format($product->price,2)}}</del></small>    ${{number_format($after_discount,2)}}  </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        @if($product->size)
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Size</h5>
                                                        <select>
                                                            @php
                                                            $sizes=explode(',',$product->size);
                                                            // dd($sizes);
                                                            @endphp
                                                            @foreach($sizes as $size)
                                                                <option>{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="col-lg-6 col-12">
                                                        <h5 class="title">Color</h5>
                                                        <select>
                                                            <option selected="selected">orange</option>
                                                            <option>purple</option>
                                                            <option>black</option>
                                                            <option>pink</option>
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        @endif
                                        <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
													<input type="hidden" name="slug" value="{{$product->slug}}">
                                                    <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to cart</button>
                                                <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                        <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @endforeach
@endif
<!-- Modal end -->
@endsection

@push('styles')
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&product=inline-share-buttons' async='async'></script>
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
        background: #000000;
        color:black;
        }

        #Gslider .carousel-inner{
        height: 550px;
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #F7941D;
        }

        #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
        bottom: 70px;
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
    <script>
        // When the car maker dropdown changes
        $('#carMaker').on('change', function () {
            var carMakerId = $(this).val();
    
            // Make an AJAX request to fetch the models based on the selected car maker
            $.ajax({
                url: '/get-vehicle-models', // Replace with your actual endpoint
                type: 'GET',
                data: { carMakerId: carMakerId },
                success: function (data) {
                    // Update the model dropdown options
                    //$('#modelLine').prop('disabled', false);
                    $('#modelLine').niceSelect('destroy');
                    $('#modelLine').html('<option value="0: null">Select Model Line</option>' + data.options);
                   
                    // Enable the model dropdown
                    $('#modelLine').prop('disabled', false);
                    
                    $('#modelLine').niceSelect();
                   // $('#modelLine').removeAttr('disabled');
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
        

         // When the car maker dropdown changes
         $('#modelLine').on('change', function () {
            var carModelId = $(this).val();
    
            // Make an AJAX request to fetch the models based on the selected car maker
            $.ajax({
                url: '/get-vehicle-model-years', // Replace with your actual endpoint
                type: 'GET',
                data: { carModelId: carModelId },
                success: function (data) {
                    // Update the model dropdown options
                    //$('#modelLine').prop('disabled', false);
                    $('#vehicle-year').niceSelect('destroy');
                    $('#vehicle-year').html('<option value="0: null">Select Vehicle Year</option>' + data.options);
                   
                    // Enable the model dropdown
                    $('#vehicle-year').prop('disabled', false);
                    $('#search-items').prop('disabled', false);
                    
                    $('#vehicle-year').niceSelect();
                   // $('#modelLine').removeAttr('disabled');
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    </script>

@endpush
