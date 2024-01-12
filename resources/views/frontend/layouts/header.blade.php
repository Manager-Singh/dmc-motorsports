<header class="header shop">
<div class="container-fluid py-3 top-bar px-lg-5 d-none d-lg-block">
        <div class="row">
            <div class="col-md-6 text-center d-inline-flex text-lg-left mb-2 mb-lg-0">
				 <div class="d-inline-flex align-items-center">
                    <a class="text-body pr-2" href="">
                        <i class="fa fa-facebook-f"></i>
                    </a>
                    <a class="text-body px-2" href="">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a class="text-body px-2" href="">
                        <i class="fa fa-linkedin"></i>
                    </a>
                    <a class="text-body px-2" href="">
                        <i class="fa fa-instagram"></i>
                    </a>
                    <a class="text-body px-2" href="">
                        <i class="fa fa-youtube"></i>
                    </a>
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
            <div class="col-md-6 text-center text-lg-right">
           
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
                                                       // $photo=explode(',',$data->product['photo']);
                                                        $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$data->product->images[0]->filename;
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
                <a href="" class="navbar-brand">
						@php
                            $settings=DB::table('settings')->get();
                        @endphp  
                    <img src="@foreach($settings as $data) {{$data->logo}} @endforeach" />
                </a>
				<div class="search-tab">	
                <form method="POST" action="{{route('product.search')}}">
                                @csrf
					<input class="search-input" type="text" id="searchwords" name="textsearch" autocorrect="off">
					<button id="searchButton" class="search-button"><span class="sr-only">Search</span><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
                </div>
				<div class="nav-text">
					
				</div>
           
   
            </nav>
        </div>
    </div>

	<div class="container-fluid sticky-top nav-bar px-3">
        <div class="position-relative">
            <nav class="navbar navbar-expand-lg navbar-dark">
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
        </div>
    </div>


   
   
</header>

