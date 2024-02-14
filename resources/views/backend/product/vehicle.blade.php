@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Product Vehicles</h5>
    <div class="card-body">
      <h2>{{$product->name}}  
        @if($product->type=='wps')  
      <a href="{{route('update.item.wps.vehicles',$product->wps_id)}}" class="sync-vehicles float-right mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Synchronize vehicles" data-placement="bottom"><img src="{{asset('images/car.png')}}" width="32"></a>
    @endif
    </h2>
      <hr/>
    <div class="row">
    <div class="col-md-6 c-boder-right">
      <h2>Vehicles</h2>
      @php
//  print_r($product->vehicles);
  //die;
      @endphp
      @if($product->vehicles)
      <ul class="added-Vehicles">
        @foreach($product->vehicles as $ivehicles)
        <li class="{{$ivehicles->pivot->item_id}}-{{$ivehicles->pivot->vehicle_id}}">{{$ivehicles->vehiclemodel->name}} <i class="fa fa-trash" aria-hidden="true" onclick="delete_Vehicle({{$ivehicles->pivot->item_id}},{{$ivehicles->pivot->vehicle_id}})"></i></li>
        @endforeach
      </ul>
      @else
      <p class="no-vehicles">Vehicles Not Attached</p>
      @endif
      </div>
      <div class="col-md-6">
      <h2>Attach New Vehicles</h2>
      <form action="{{route('attach.vehicle')}}" class="search-vehicle-form" method="POST" >
                @csrf
          <div class="form-row">
                <div class="form-group col-md-3">
                <p>Search by vehicle models name:</p>
                    <select name="vehicle_items[]" formcontrolname="vehicleCategory" class="form-control required" id="vehicleCategory" multiple required>
                        <option value="">Select Vehicles</option>
                      
                        <!-- Add options dynamically if needed -->
                    </select>
                    <input type="hidden" name="item_id" value="{{$product->wps_id}}">
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-block btn-primary" id="search-items">Attach Vehicles</button>
                </div>
          </div>
    </form>
      </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<style>
.c-boder-right {
    border-right: 1px solid #ccc;
}
</style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}"></script>

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

  $("#vehicleCategory").select2({
    ajax: {
      url: "/get-vehicles",
      dataType: 'json',
      data: (params) => {
        return {
          q: params.term,
          item_id:<?=$product->wps_id?>
        }
      },
      processResults: (data, params) => {
       // console.log('csaf         ',data);
        const results = data.map(item => {

          console.log('csaf         ',item);
          return {
            id: item.wps_id,
            text: item.vehiclemodel.vehiclemake.name+' '+item.vehiclemodel.name+' '+item.vehicleyear.name,
          };
        });
        return {
          results: results,
        }
      },
    },
  });


        
      });

      function delete_Vehicle(item_id,vehicle_id){
        console.log('item_id',item_id);
        console.log('vehicle_id',vehicle_id);
        $.confirm({
    title: 'Confirm!',
    content: 'Do You want to delete this Item Vehicle',
    buttons: {
        confirm: function () {
          $.ajax({
                url: '/admin/delete-attached-vehicle', // Replace with your actual endpoint
                type: 'GET',
                data: { item_id: item_id ,vehicle_id:vehicle_id},
                success: function (data) {

                  if(data){
                    $('.'+item_id+'-'+vehicle_id).remove();
                  }
                    // Update the model dropdown options
                    //$('#modelLine').prop('disabled', false);
                   
                   // $('#modelLine').removeAttr('disabled');
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        },
        cancel: function () {
           
        }
    }
});
      }
</script>
@endpush