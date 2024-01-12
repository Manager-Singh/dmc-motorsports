<!-- Start Search Area -->
<section class="search-section section">
    <div class="container">
        <div class="row">
            <form action="{{route('search.items')}}" class="search-vehicle-form" method="POST" >
                @csrf
                
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <select name="vehicle_category" formcontrolname="vehicleCategory" class="form-control" id="vehicleCategory">
                            <option value="">Select Vehicle Category</option>
                            
                            @foreach($vehicle_model_categories as $vm_category)
                            <option value="{{$vm_category->category->wps_id}}">{{$vm_category->category->title}}</option>
                            @endforeach
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <select name="vehicle_maker" formcontrolname="carMaker" class="form-control" id="carMaker" disabled='disabled'>
                            <option value="0: null">Select Vehicle Maker</option>
                            
                            {{-- @foreach($vehiclemakes as $wps=>$vehiclemake)
                            <option value="{{$wps}}">{{$vehiclemake}}</option>
                            @endforeach --}}
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
        
                    <div class="form-group col-md-3">
                        <select name="vehicle_model" formcontrolname="modelLine" class="form-control" id="modelLine" disabled='disabled'>
                            <option value="0: null">Select Model Line</option>
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
        
                    <div class="form-group col-md-2">
                        <select name="vehicle_year" formcontrolname="vehicle-year" class="form-control" id="vehicle-year"  disabled='disabled'>
                            <option value="0: null">Select Year</option>
                            <!-- Add options dynamically if needed -->
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-block btn-primary" id="search-items" disabled='disabled'>Search Items</button>
                </div>

                </div>
                
            </form>
        </div>
    </div>
</section>
<!--/ End Search Area -->
@push('styles')
<style>
form.search-vehicle-form .form-control {
    width: 100% !important;

}
button#search-items {
    margin-top: 32px;
    border-radius: 5px;
}
</style>
@endpush

@push('scripts')
<script>

$('#vehicleCategory').on('change', function () {
            var vcatId = $(this).val();
    
            // Make an AJAX request to fetch the models based on the selected car maker
            $.ajax({
                url: '/get-vehicle-makes-cat', // Replace with your actual endpoint
                type: 'GET',
                data: { vcatId: vcatId },
                success: function (data) {
                    // Update the model dropdown options
                    //$('#modelLine').prop('disabled', false);
                    $('#carMaker').niceSelect('destroy');
                    $('#carMaker').html('<option value="0: null">Select Model Line</option>' + data.options);
                   
                    // Enable the model dropdown
                    $('#carMaker').prop('disabled', false);
                    
                    $('#carMaker').niceSelect();
                   // $('#modelLine').removeAttr('disabled');
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
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