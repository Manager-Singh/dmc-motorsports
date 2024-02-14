@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.update',$product->wps_id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$product->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Sku <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="sku" placeholder="Enter sku"  value="{{$product->sku}}" class="form-control">
          @error('sku')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          @if($product->product)
          <input type="hidden" name="product_wps_id" value="{{$product->product->wps_id}}">
          <textarea class="form-control" id="description" name="description">{{$product->product->description}}</textarea>
          @else
          <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
          @endif
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price(USD) <span class="text-danger">*</span></label>
          <input id="price" type="text" name="price" placeholder="Enter price"  value="{{$product->list_price}}" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

       
        <div class="form-group">
          <label for="brand_id">Brand</label>
          <select name="brand_id" class="form-control">
              <option value="">--Select Brand--</option>
             @foreach($brands as $brand)
              <option value="{{$brand->wps_id}}" {{(($product->brand_id==$brand->wps_id)? 'selected':'')}}>{{$brand->title}}</option>
             @endforeach
          </select>
        </div>


        <div class="form-group">
          <label for="stock">Inventory <span class="text-danger">*</span></label>
          <input id="quantity" type="number" name="stock" min="0" placeholder="Enter inventory"  value="{{@$product->inventory->total}}" class="form-control">
          @error('stock')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          @if(isset($product->images[0]))

        
          @if($product->images[0]->domain == 'dmc-motorsports.com')
          @php
          $fimg_url = 'https://'.$product->images[0]->domain.$product->images[0]->path.'/'.$product->images[0]->filename;
          $sfimg_url = $product->images[0]->path.'/'.$product->images[0]->filename;
          @endphp
          @else
          @php
          $fimg_url = 'http://cdn.wpsstatic.com/images/full/'.$product->images[0]->filename;
          $sfimg_url='';
          @endphp
          @endif
          @endif
            <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Choose
                    </a>
                </span>
            <input id="thumbnail" class="form-control" type="text" name="photo" value="">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>

          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
       
          <img class="default-img" src="{{@$fimg_url}}" alt="{{@$fimg_url}}" with=400 height=200>
        
        </div>
        <div class="form-group">
            <label for="categories" class="col-form-label">Categories <span class="text-danger">*</span></label>
            @php 
                $selected_categories = $product->categories->pluck('wps_id')->toArray();
            @endphp
            <select name="categories[]" class="form-control categories" multiple>
                @foreach($categories as $cvkey => $category)
                    <option value="{{$cvkey}}" {{(in_array($cvkey, $selected_categories)? 'selected' : '')}}>{{$category}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="attributevalues" class="col-form-label">Attributes <span class="text-danger">*</span></label>
            @php 
                $attributevalues_wps_ids = $product->attributevalues->pluck('wps_id')->toArray();
                //print_r($attributevalues_wps_ids);
                //print_r('<br>');
                //print_r($attributevalues); 
            @endphp
            <select name="attributevalues[]" class="form-control attributevalues" multiple>
                @foreach($attributevalues as $attributevalue)
                    <option value="{{$attributevalue['wps_id']}}" {{(in_array($attributevalue['wps_id'], $attributevalues_wps_ids)? 'selected' : '')}}>{{getAttributeKeyName($attributevalue['attributekey_id'])}} {{$attributevalue['name']}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="STK" {{(($product->status=='STK')? 'selected' : '')}}>STANDARD STOCKING ITEM</option>
            <option value="SPEC" {{(($product->status=='SPEC')? 'selected' : '')}}>SPECIAL ORDER</option>
            <option value="PRE" {{(($product->status=='PRE')? 'selected' : '')}}>PRE -RELEASE ITEM</option>
            <option value="NEW" {{(($product->status=='NEW')? 'selected' : '')}}>NEW ITEM</option>
            <option value="DIR" {{(($product->status=='DIR')? 'selected' : '')}}>DIRECT SHIP FROM VENDOR</option>
            <option value="DSC" {{(($product->status=='DSC')? 'selected' : '')}}>DISCONTINUED ITEM</option>
            <option value="CLO" {{(($product->status=='CLO')? 'selected' : '')}}>CLOSEOUT ITEM</option>
            <option value="NA" {{(($product->status=='NA')? 'selected' : '')}}>NOT AVAILABLE AT THIS TIME</option>
            <option value="NLA" {{(($product->status=='NLA')? 'selected' : '')}}>NO LONGER AVAILABLE</option>
        </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail Description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>

<script>
  var  child_cat_id='{{$product->child_cat_id}}';
        // alert(child_cat_id);
        $('#cat_id').change(function(){
            var cat_id=$(this).val();

            if(cat_id !=null){
                // ajax call
                $.ajax({
                    url:"/admin/category/"+cat_id+"/child",
                    type:"POST",
                    data:{
                        _token:"{{csrf_token()}}"
                    },
                    success:function(response){
                        if(typeof(response)!='object'){
                            response=$.parseJSON(response);
                        }
                        var html_option="<option value=''>--Select any one--</option>";
                        if(response.status){
                            var data=response.data;
                            if(response.data){
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data,function(id,title){
                                    html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected ' : '')+">"+title+"</option>";
                                });
                            }
                            else{
                                console.log('no response data');
                            }
                        }
                        else{
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);

                    }
                });
            }
            else{

            }

        });
        if(child_cat_id!=null){
            $('#cat_id').change();
        }

        $(document).ready(function() {
          $(".categories").select2({
            tags: false
        });
        $(".attributevalues").select2({
            tags: false
        });
        
      });
       // Function to generate tag list with key-value pairs
    // function generateTagList(categories) {
    //     var tagList = [];
    //     $.each(categories, function(key, value) {
    //         tagList.push({ value: key, text: value });
    //     });
    //     return tagList;
    // }
</script>
@endpush