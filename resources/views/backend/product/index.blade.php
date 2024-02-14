@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Items Lists</h6>
      <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="card-body">
    <div class="mx-auto pull-right">
            <div class="listing-search-form">
                <form action="{{ route('product.index') }}" method="GET" role="search">

                    <div class="input-group">
                        <input type="text" class="form-control mr-2" name="term" placeholder="Search Items" value="{{@$_GET['term']}}" id="term">
                        <a href="{{ route('product.index') }}" class=" mt-1">
                            <span class="input-group-btn">
                            <button class="btn btn-info" type="submit" title="Search Items">
                                  <span class="fas fa-search"></span>
                               </button>
                                <button class="btn btn-danger" type="button" title="Refresh page">
                                    <span class="fas fa-sync-alt"></span>
                                </button>
                               
                            </span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
      <div class="table-responsive">
        @if(count($products)>0)
        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>SKU</th>
              <th>Title</th>
              <th>Product Type</th>
              <th>Category</th>
              <!-- <th>Product Description</th> -->
              <th>Price ($)</th>
              <!-- <th>Discount</th> -->
              <!-- <th>Size</th> -->
              <!-- <th>Condition</th> -->
              <th>Brand</th>
              <th>Stock</th>
              <th>Photo</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th>SKU</th>
              <th>Title</th>
              <th>Product Type</th>
              <th>Category</th>
              <!-- <th>Product Description</th> -->
              <th>Price ($)</th>
              <!-- <th>Discount</th> -->
              <!-- <th>Size</th> -->
              <!-- <th>Condition</th> -->
              <th>Brand</th>
              <th>Stock</th>
              <th>Photo</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
          @php
           //print_r($products);
            //  die;
             @endphp
            @foreach($products as $product)
              @php
             // print_r($product);
             // die;
             // $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
              // dd($sub_cat_info);
             // $brands=DB::table('brands')->select('title')->where('id',$product->brand_id)->get();
              @endphp
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{$product->sku}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->product_type}}</td>
                    <td>
                      @php
                      $total_cats  = count($product->categories);
                      $counter = 1;
                      @endphp
                      @foreach($product->categories as $cat)
                     
                      <cat>
                          {{$cat->title ?? ''}}
                      </cat>
                      @if($total_cats >$counter)
                      ,
                      @endif
                      @php
                      $counter++
                      @endphp
                      @endforeach
                    </td>
                    <td>{{$product->list_price}} /-</td>
                    <!-- <td>{{$product->discount}}% OFF</td> -->
                    <!-- <td>{{$product->size}}</td> -->
                    <!-- <td>{{$product->condition}}</td> -->
                    <td> {{ucfirst(@$product->brand->title)}}</td>
                    <td>
                      @if(getInventory($product->wps_id)>0)
                      <span class="badge badge-primary">{{getInventory($product->wps_id)}}</span>
                      @else
                      <span class="badge badge-danger">{{getInventory($product->wps_id)}}</span>
                      @endif
                    </td>
                    <td>
                        
                            @if(count($product->images)>0)
                              @php
                            
                              $image = $product->images[0];
                              if($image->domain == 'dmc-motorsports.com'){
                                $fimg_url = 'https://'.$image->domain.$image->path.'/'.$image->filename;
                              }else{
                                $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$image->filename;
                              }
                              //$fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$f_item_image->filename;    
                              @endphp
                              @else
                              @php
                              $fimg_url = asset('backend/img/thumbnail-default.jpg');
                              @endphp
                            @endif
                            <img src="{{$fimg_url}}" class="img-fluid zoom" style="max-width:80px" alt="{{$fimg_url}}">
                       
                    </td>
                    <td>
                        @if($product->status=='NEW')
                            <span class="badge badge-success">{{$product->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$product->status}}</span>
                        @endif
                    </td>
                    <td>
                    <a href="{{route('product.vehicle.edit',$product->wps_id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-car"></i></a>   
                    <a href="{{route('product.edit',$product->wps_id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    @if($product->type=='wps')  
                    <a href="{{route('update.item.wps.images',$product->wps_id)}}" class="float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Synchronize Images" data-placement="bottom"><img src="{{asset('images/synchronize.png')}}" width="32"></a>
                    <a href="{{route('update.item.wps.vehicles',$product->wps_id)}}" class="float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Synchronize vehicles" data-placement="bottom"><img src="{{asset('images/car.png')}}" width="32"></a>
                    @endif
                    <!-- <form method="POST" action="{{route('product.destroy',[$product->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$product->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form> -->
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          {{ $products->links('vendor.pagination.bootstrap-4') }}
      </div>
        @else
          <h6 class="text-center">No Products found!!! Please create Product</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#product-dataTable').DataTable( {
        "scrollX": false
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[10,11,12]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
