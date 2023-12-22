@extends('backend.layouts.master')

@section('main-content')

<div class="card" style="display:block">
    <h5 class="card-header">WPS API's Endspoints</h5>
    <div class="card-body">
    <form method="post" action="{{route('api.endpoint.create')}}">
        @csrf 
        <div class="form-group">
          <label for="endpoint" class="col-form-label">API Endpoint <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="endpoint" required value="">
          @error('endpoint')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="include" class="col-form-label">API Include <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="include" value="">
          @error('include')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="api_token" class="col-form-label">API Token <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="api_token" required value="">
          @error('api_token')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="size">Database Model Name</label>
          <select name="table_name" class="form-control selectpicker" data-live-search="true" required>
              <option value="">--Select Table--</option>
              @foreach(Helper::getModels() as $modalName)
              <option value="{{$modalName}}">{{$modalName}}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="per_page" class="col-form-label">Record Size <span class="text-danger"></span></label>
          <input type="text" class="form-control" name="per_page" value="20">
          @error('per_page')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="filter" class="col-form-label">Filter <span class="text-danger"></span></label>
          <input type="text" class="form-control" name="filter">
          @error('filter')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="filter_value" class="col-form-label">Filter Value <span class="text-danger"></span></label>
          <input type="text" class="form-control" name="filter_value">
          @error('filter_value')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">ADD</button>
        </div>
      </form>
    </div>
</div>
<div class="card">
  <h5 class="card-header">API's Endspoints List</h5>
    <div class="card-body">
      <div class="api-list">
        @foreach($data as $key=>$apis)
        <div class="malert alert-primary">
          <span class="requet-number">{{$key}}</span>
          <span class="icon">
            {{Str::upper($apis->request_type)}}
          </span>
          <div class="text">
            <p>{{$apis->endpoint}} <strong>Model Name:</strong> {{$apis->table_name}} <strong>Request Status:</strong><span class="requestStatus-{{$apis->id}}">{{$apis->status}} </span><strong>Record Size:</strong>{{$apis->per_page}}</p>
            @if($apis->include) <p><strong>Include :</strong> {{$apis->include}}</p>@endif
            @if($apis->filter) <p><strong>Filter :</strong> {{$apis->filter}} | {{$apis->filter_value}}</p>@endif
          </div>
          <button class="sync"  data-id={{$apis->id}}>
            <i class="fas fa-sync sync-{{$apis->id}}"></i>
          </button>
            
            {{-- <form method="POST" action="{{route('api.endpoint.delete',[$apis->id])}}">
              @csrf
              @method('delete')
                  <button class="btn btn-danger btn-sm dltBtn delete" data-id={{$apis->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
            </form> --}}
        </div>
        @endforeach
      </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
:root {
  --default: #999;
  --success: #51be56;
  --warning: #ffc107;
  --danger: #ff5722;
  --primary: #29b6f6;
}

.malert {
  border: 1px solid var(--default);
  border-left: 5px solid var(--default);
  box-shadow: 0 0 4px #ddd, 0 2px 10px #ddd, 0 2px 20px #ddd;

  display: flex;
  align-items: center;
  padding: 2px 12px;
  margin-bottom: 8px;
  transition: 0.5s ease-in;
}

.malert.close {
  transform: translateY(40px);
  background: #fff;
  opacity: 0;
}

.malert > .icon {
  background-color: var(--default);
  display: inline-block;
  color: #fff;
  text-align: center;
  padding: 3px 17px;
}

.malert > .icon > .fa {
  line-height: 40px;
}

.malert > .text {
  width: 100%;
  padding: 0 15px;
  
}

.malert > .text strong {
  color: #333;
}
.malert > .text p {
  color: #666;
  margin: 5px 0;
  font-size: 14px;
  width: 1019px;
}

.malert > .delete {
  border: none;
  background: transparent;
  font-size: 16px;
  color: #777;
  outline: none;
  cursor: pointer;
  transition: 0.3 ease-in-out;
}
.malert > .delete:hover {
  color: red;
}
.malert > .sync {
  border: none;
  background: transparent;
  font-size: 16px;
  color: #777;
  outline: none;
  cursor: pointer;
  transition: 0.3 ease-in-out;
}
.malert > .sync:hover {
  color: var(--primary);
}


/* success alert start */
.alert-success {
  border: 1px solid var(--success);
  border-left: 5px solid var(--success);
}
.alert-success > .icon {
  background-color: var(--success);
}
/* success alert end */

/* warning alert start */
.alert-warning {
  border: 1px solid var(--warning);
  border-left: 5px solid var(--warning);
}
.alert-warning > .icon {
  background-color: var(--warning);
}
/* warning alert end */

/* danger alert start */
.alert-danger {
  border: 1px solid var(--danger);
  border-left: 5px solid var(--danger);
}
.alert-danger > .icon {
  background-color: var(--danger);
}
/* danger alert end */

/* primary alert start */
.alert-primary {
  border: 1px solid var(--primary);
  border-left: 5px solid var(--primary);
}
.alert-primary > .icon {
  background-color: var(--primary);
}
@-webkit-keyframes rotating {
    from{
        -webkit-transform: rotate(0deg);
    }
    to{
        -webkit-transform: rotate(360deg);
    }
}

.rotating {
  color: blue;
    -webkit-animation: rotating 2s linear infinite;
}
.requet-number {
  padding: 0px 5px 0px 0px;
    font-weight: 600;
    width: 45px;
    text-align: center;
}
</style>

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
  
    $(document).ready(function() {
      
      // $(".sync i").hover(function(){
      //   $(this).toggleClass("rotating");
      // });
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
          });
          $('.sync').click(function (e) {
    var dataID = $(this).data('id');

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Don't close this window while the request is not completed!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((result) => {
        console.log(result);
        // Check if the user clicked the "Yes" button
        if (result) {
            $('.sync-' + dataID).addClass("rotating");
            
            // Make the AJAX request using jQuery
            $.ajax({
                url: '{{ route("api.endpoint.call") }}',
                type: 'POST',
                timeout: 0,
                dataType: 'json',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    // You may need to include additional headers here
                },
                data: JSON.stringify({ id: dataID }),
                success: function (data) {
                    // Handle the response data as needed
                   var ndata = JSON.stringify(data)
                    $('.sync-' + dataID).removeClass("rotating");
                    $('.requestStatus-' + dataID).text('Completed');
                    
                    swal({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                    });
                },
                error: function (error) {
                    // Handle errors
                    $('.sync-' + dataID).removeClass("rotating");
                    swal({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while making the request.',
                    });
                }
            });
        } else {
            swal("Sync Request Cancelled/");
        }
    });
});
          
    });
</script>
@endpush