<header class="header shop">
<div class="container-fluid py-3 top-bar px-lg-5 d-none d-lg-block">
        <div class="row">
            <div class="col-md-5 text-center d-inline-flex text-lg-left mb-2 mb-lg-0">
				 <div class="d-inline-flex align-items-center">
                    <a class="text-body pr-2" href="https://www.facebook.com/DMCMotorsports14/">
                        <i class="fa fa-facebook-f"></i>
                    </a>
                    <!-- <a class="text-body px-2" href="">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a class="text-body px-2" href="">
                        <i class="fa fa-linkedin"></i>
                    </a> -->
                    <a class="text-body px-2" href="https://www.instagram.com/dmc_motorsports/">
                        <i class="fa fa-instagram"></i>
                    </a>
                    <!-- <a class="text-body px-2" href="">
                        <i class="fa fa-youtube"></i>
                    </a> -->
                </div>
                 <!-- Top Left -->
                 <div class="top-left pl-3">
                        <ul class="list-main">
                            @php
                                $settings=DB::table('settings')->get();
                                
                            @endphp
                            <li><i class="ti-headphone-alt"></i>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
                            <li><i class="ti-email"></i> @foreach($settings as $data) {{$data->email}} @endforeach</li>
                        </ul>
                    </div>
					
                    <!--/ End Top Left -->
            </div>
			<div class="col-md-3 header-top-search text-center d-inline-flex text-lg-left mb-2 mb-lg-0">
			 <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form" method="GET" action="{{route('top.product.search')}}">
                                
                                <input type="text" placeholder="Search here..." name="term" value={{@$term}}>
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
			</div>
        
            <div class="col-md-4 text-center text-lg-right">
                       
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php 
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                           @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod+=$wishlist_items['quantity'];
                                        $total_amount+=$wishlist_items['amount'];
                                    @endphp
                                @endforeach
                           @endif
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span class="total-count">{{Helper::wishlistCount()}}</span></a>
                            <!-- Shopping Item -->
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                        <a href="{{route('wishlist')}}">View Wishlist</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromWishlist() as $data)
                                                    @php
                                                      //  $photo=explode(',',$data->product['photo']);
                                                        $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$data->product->images[0]->filename;
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$fimg_url}}" alt="{{$fimg_url}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                    </div>
                                </div>
                            <!--/ End Shopping Item -->
                        </div>
                        {{-- <div class="sinlge-bar">
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        </div> --}}
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromCart() as $data)
                                                    @php

                                                    if(count($data->product->images)>0){
                                                    $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$data->product->images[0]->filename;
                                                    }else{
                                                        $fimg_url = asset('backend/img/thumbnail-default.jpg');
                                                    }
                                                        
                                                    @endphp
                                                    
                                                    <li>
                                                        <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#"><img src="{{$fimg_url}}" alt="{{$fimg_url}}"></a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            <!--/ End Shopping Item -->
                        </div>
                    </div>

                    <div class="right-content">
                        <ul class="list-main">
                        <li><i class="ti-location-pin"></i> <a href="{{route('order.track')}}">Track Order</a></li>
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth 
                                @if(Auth::user()->role=='admin')
                                    <li><i class="ti-user"></i> <a href="{{route('admin')}}"  target="_blank">Dashboard</a></li>
                                @else 
                                    <li><i class="ti-user"></i> <a href="{{route('user')}}"  target="_blank">Dashboard</a></li>
                                @endif
                                <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li>

                            @else
                                <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
               
            </div>
        </div>
    </div>

    <div class="container-fluid position-relative nav-bar p-0">
        <div class="position-relative">
            <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="{{route('home')}}" class="navbar-brand">
						@php
                            $settings=DB::table('settings')->get();
                            
                            if(isset($product_category) && isset($product_brand)){
                                $productTypes =$fproductsTypesData;
                            }else{
                                $productTypes = DB::table('items')->groupBy('product_type')->orderBy('product_type','ASC')->pluck('product_type','product_type');

                            }
                          //  $fbrands = DB::table('brands')->has('items')->orderBy('title','ASC')->pluck('title','wps_id');

                          if(isset($product_category)){
                            $fbrands = $filter_brands;
                          }else{
                            $fbrands = DB::table('brands')
                            ->join('items', 'brands.wps_id', '=', 'items.brand_id')
                            ->orderBy('brands.title', 'ASC')
                            ->pluck('brands.title', 'brands.wps_id');
                          }
                          if(isset($product_category) && !isset($product_brand) && !isset($product_type)){
                           
                            $productTypes = $filtered_product_types;
                          }
                          if(!isset($product_category) && isset($product_brand) && !isset($product_type)){
                           
                           $productTypes = $fproductsTypesData;
                         }
                         // fproductsTypesData
                         
                            $fcategories = DB::table('categories')->where('vocabulary_id',15)->orderBy('title','ASC')->pluck('title','wps_id');

                           // print_r($productTypes);
                          //  print_r('<br>');
                         //   print_r($fbrands);
                          //  print_r('<br>');
                           // die;
                          //  print_r($fcategories);

                        @endphp  
                    <img src="@foreach($settings as $data) {{$data->logo}} @endforeach" />
                </a>
				<div class="search-tab search-tab-new" id="top-search">

                <form class="top-search-form" method="POST" action="{{route('product.search')}}">
                                @csrf
                          <p class="headline-title">Search Products:</p>
            <div class="form-row">
                <div class="form-group col-md-3">
                        <select name="product_category" formcontrolname="product_category" class="form-control" id="product_category">
                            <option value="">Select Categories</option>
                            
                            @foreach($fcategories as $ckey => $fcategorie)
                            <option value="{{$ckey}}" @if(isset($product_category) && $product_category == $ckey) selected @endif>{{$fcategorie}}</option>
                            @endforeach
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="product_brand" formcontrolname="product_brand" class="form-control" id="product_brand">
                            <option value="">Select Brand</option>
                            
                            @foreach($fbrands as $bkey => $fbrand)
                            <option value="{{ $bkey }}" @if(isset($product_brand) && $product_brand == $bkey) selected @endif>{{ $fbrand }}</option>
                            @endforeach
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="product_type" formcontrolname="product_type" class="form-control" id="product_type">
                            <option value="">Select Product Type</option>
                            
                            @foreach($productTypes as $pkey => $productType)
                            <option value="{{$pkey}}" @if(isset($product_type) && $product_type == $pkey) selected @endif>{{$productType}}</option>
                            @endforeach
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
                  
                    <!-- <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-block btn-primary" id="search-product">Search</button>
                </div> -->
                   

                </div>
					<!-- <input class="search-input" type="text" id="searchwords" name="search" autocorrect="off"> -->
					<!-- <button id="searchButton" class="search-button"><span class="sr-only">Search</span><i class="fa fa-search" aria-hidden="true"></i></button> -->
                </form>
                </div>
				<div class="nav-text">
					
				</div>
           
   
            </nav>
        </div>
    </div>

	<div class="container-fluid sticky-top nav-bar px-3">
        <div class="position-relative">
            <nav class="navbar navbar-expand-lg navbar-dark desktop">
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav py-0">
                    <ul class="nav main-menu menu navbar-nav">
                        <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                        <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li>
                        <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="{{route('product-grids')}}">Products</a><span class="new">New</span></li>												
                        {{Helper::getHeaderAttributeValues()}}  
                        <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>									
                            
                        <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                    </ul>
                    </div>
                </div>
            </nav>
			
		<nav class="navbar navbar-expand-lg navbar-light mobile">
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item {{Request::path()=='home' ? 'active' : ''}}">
				<a class="nav-link" href="{{route('home')}}">Home</span></a>
			  </li>
			  <li class="nav-item {{Request::path()=='about-us' ? 'active' : ''}}">
				<a class="nav-link" href="{{route('about-us')}}">About Us</a>
			  </li>
			  <li class="nav-item @if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif">
				<a class="nav-link" href="{{route('product-grids')}}" >Products<span class="new">New</span></a>
			  </li>
			  {{Helper::getHeaderAttributeValues()}} 
			  <li class="nav-item {{Request::path()=='blog' ? 'active' : ''}}">
				<a class="nav-link" href="{{route('blog')}}">Blog</a>
			  </li>
			  <li class="nav-item {{Request::path()=='contact' ? 'active' : ''}}">
				<a class="nav-link" href="{{route('contact')}}">Contact Us</a>
			  </li>
			</ul>
		  </div>
		</nav>
        </div>
    </div>
	
	


   
   
</header>

