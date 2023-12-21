@if($allItems)
                        @foreach($allItems as $key=>$allItem)
                        @php
                        $product = $allItem->item;
                        @endphp
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="{{route('product-detail',$product->slug)}}">
                                                {{-- @php
                                                    $photo=explode(',',$product->photo);
                                                @endphp --}}
                                                @if(count($product->images)>0)
                                                @php
                                                    // $photo=explode(',',$cat->photo);
                                                    // // dd($photo);
                                                    $f_item_image = $product->images[0];
                                      // print_r($f_item_image);
                                        $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$f_item_image->filename;
                                                    
                                                @endphp
                                                @else
                                                @php
                                                $fimg_url = 'backend/img/thumbnail-default.jpg';
                                                @endphp
                                                 @endif
                                                <img class="default-img" src="{{$fimg_url}}" alt="{{$fimg_url}}">
                                                <img class="hover-img" src="{{$fimg_url}}" alt="{{$fimg_url}}">
                                                @if($product->discount)
                                                            <span class="price-dec">{{$product->discount}} % Off</span>
                                                @endif
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action">
                                                    <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                    <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" class="wishlist" data-id="{{$product->id}}"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                </div>
                                                <div class="product-action-2">
                                                    <a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->name}} </a></h3>
                                            @php
                                                $after_discount=($product->list_price-($product->list_price*$product->discount)/100);
                                            @endphp
                                            <span>${{number_format($after_discount,2)}}</span>
                                            <del style="padding-left:4%;">${{number_format($product->list_price,2)}}</del>
                                        </div>
                                    </div>
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
                                                                        <h4>Size</h4>
                                                                        <ul>
                                                                            @php
                                                                                $sizes=explode(',',$product->size);
                                                                                // dd($sizes);
                                                                            @endphp
                                                                            @foreach($sizes as $size)
                                                                            <li><a href="#" class="one">{{$size}}</a></li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                @endif
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
                                                                <form action="{{route('single-add-to-cart')}}" method="POST">
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
                                </div>
                            @endforeach
                            <div>
                            </div>
                       
                        @endif