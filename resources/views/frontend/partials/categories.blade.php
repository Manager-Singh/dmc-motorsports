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
                                        $fimg_url = asset('backend/img/thumbnail-default.jpg');
                                                
                                        @endphp
                                         @endif
                                    <img src="{{$fimg_url}}" alt="#">
                                    @endif
                <a href="{{route('new-product-cat',$cat->wps_id)}}" class="buy"><i class="fa fa-eye"></i></a>
                {{-- @endif --}}
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12 no-padding">
            <div class="content">
                <h4 class="title"><a href="{{route('new-product-cat',$cat->wps_id)}}">{{$cat->title}}</a></h4>
                {{-- <p class="price with-discount">${{number_format($product->discount,2)}}</p> --}}
            </div>
        </div>
        </div>
    </div>
    <!-- End Single List  -->
</div>
@endforeach