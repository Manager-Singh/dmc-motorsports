@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Sku <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="sku" placeholder="Enter sku"  value="" class="form-control">
          @error('sku')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>



        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description"></textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price(USD) <span class="text-danger">*</span></label>
          <input id="price" type="text" name="price" placeholder="Enter price"  value="" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
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
          <label for="brand_id">Brand</label>
          <select name="brand_id" class="form-control">
              <option value="">--Select Brand--</option>
             @foreach($brands as $brand)
              <option value="{{$brand->wps_id}}">{{$brand->title}}</option>
             @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="brand_id">Product Type</label>
          <select name="product_type" class="form-control">
              <option value="">--Select Product Type--</option>
             @foreach($product_type as $product_type)
              <option value="{{$product_type}}">{{$product_type}}</option>
             @endforeach
          </select>
        </div>


        <div class="form-group">
          <label for="stock">Inventory <span class="text-danger">*</span></label>
          <input id="quantity" type="number" name="stock" min="0" placeholder="Enter inventory"  value="" class="form-control">
          @error('stock')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
            <label for="categories" class="col-form-label">Categories <span class="text-danger">*</span></label>
          
            <select name="categories[]" class="form-control categories" multiple>
                @foreach($categories as $cvkey => $category)
                    <option value="{{$cvkey}}">{{$category}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="attributevalues" class="col-form-label">Attributes <span class="text-danger">*</span></label>
           
            <select name="attributevalues[]" class="form-control attributevalues" multiple>
                @foreach($attributevalues as $attributevalue)
                    <option value="{{$attributevalue->wps_id}}">{{getAttributeKeyName($attributevalue->attributekey_id)}} {{$attributevalue->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="STK">STANDARD STOCKING ITEM</option>
            <option value="SPEC">SPECIAL ORDER</option>
            <option value="PRE">PRE -RELEASE ITEM</option>
            <option value="NEW">NEW ITEM</option>
            <option value="DIR">DIRECT SHIP FROM VENDOR</option>
            <option value="DSC">DISCONTINUED ITEM</option>
            <option value="CLO">CLOSEOUT ITEM</option>
            <option value="NA" >NOT AVAILABLE AT THIS TIME</option>
            <option value="NLA">NO LONGER AVAILABLE</option>
        </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
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
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
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
  })

  $(document).ready(function() {
          $(".categories").select2({
            placeholder: "Select an categories",
            tags: false
        });
        $(".attributevalues").select2({
          placeholder: "Select an attributes",
            tags: false
        });
        
      });
</script>
@endpush