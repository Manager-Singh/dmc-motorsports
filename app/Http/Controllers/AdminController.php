<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Helper;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\Endpoint;
use App\Models\Category;
use App\Models\Product;
use App\Models\Feature;
use App\Models\Image;
use App\Models\ProductImage;
use App\Models\ItemImage;
use App\Models\Tag;
use App\Models\ProductTag;     
use App\Models\ItemTag;     
use App\Models\Item;
use App\Models\Attributekey;
use App\Models\Attributevalue; 
use App\Models\ItemAttributevalue;
use App\Models\Brand;
use App\Models\Country;
use App\Models\ItemVehicle;
use App\Models\ItemCategory;
use App\Models\Vehicle;
use App\Models\Vehiclemake;
use App\Models\Vehiclemodel;
use App\Models\Vehicleyear;
use App\Models\Resource;
use App\Models\ProductResource;
use App\Models\CategoryImage;
use App\Models\VehiclemodelCategory;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index(){
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
     return view('backend.index')->with('users', json_encode($array));
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();
        $user=User::findOrFail($id);
        $data=$request->all();
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    public function settings(){
        $data=Settings::first();
        return view('backend.setting')->with('data',$data);
    }

    public function settingsUpdate(Request $request){
        // return $request->all();
        $this->validate($request,[
            'short_des'=>'required|string',
            'description'=>'required|string',
            'photo'=>'required',
            'logo'=>'required',
            'address'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required|string',
        ]);
        $data=$request->all();
        // return $data;
        $settings=Settings::first();
        // return $settings;
        $status=$settings->fill($data)->save();
        if($status){
            request()->session()->flash('success','Setting successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again');
        }
        return redirect()->route('admin');
    }

    public function changePassword(){
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success','Password successfully changed');
    }

    // Pie chart
    public function userPieChart(Request $request){
        // dd($request->all());
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
     return view('backend.index')->with('course', json_encode($array));
    }

    // public function activity(){
    //     return Activity::all();
    //     $activity= Activity::all();
    //     return view('backend.layouts.activity')->with('activities',$activity);
    // }

    public function storageLink(){
        // check if the storage folder already linked;
        if(File::exists(public_path('storage'))){
            // removed the existing symbolic link
            File::delete(public_path('storage'));

            //Regenerate the storage link folder
            try{
                Artisan::call('storage:link');
                request()->session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            }
            catch(\Exception $exception){
                request()->session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
        else{
            try{
                Artisan::call('storage:link');
                request()->session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            }
            catch(\Exception $exception){
                request()->session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
    }

    public function apiSettings(Request $request){
        $data=Endpoint::get();
        return view('backend.api-setting')->with('data',$data);
    }

    public function apiEndpointCreate(Request $request){
       //return $request->all();
        $this->validate($request,[
            'endpoint'=>'required|string',
            'api_token'=>'required|string',
            'table_name'=>'required|string',
        ]);
        $endpoint = new Endpoint;
        $endpoint->endpoint = $request->endpoint;
        $endpoint->include = $request->include;
        $endpoint->api_token = $request->api_token;
        $endpoint->table_name = $request->table_name;
        $endpoint->per_page = $request->per_page;
        
        if($endpoint->save()){
            request()->session()->flash('success', 'Successfully Endpoint added.');
            return redirect()->back()->with('success','Successfully Endpoint added.');
        }else{
            request()->session()->flash('error', "Error while creating Endpoint");
        } 
        return redirect()->route('api.settings');
    }
    
    public function apiEndpointDelete($id){
        $endpoint=Endpoint::findOrFail($id);
        $endpoint=$endpoint->delete();
        
        if($endpoint){
            request()->session()->flash('success','Endpoint successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting Endpoint');
        }
        return redirect()->route('api.settings');
      }

      public function endpointCall(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|numeric',
                // Add other validation rules as needed
            ]);

            $endpoint = Endpoint::findOrFail($request->id);
            // $endpoint->status = 'Processing';
            // $endpoint->save();
//             print_r($endpoint);
// die;
            $actualUrl = stripslashes($endpoint->endpoint);
            $modalUrl = $endpoint->table_name;
            // print_r($actualUrl);
            // die;
           
            
            if($endpoint->status = 'Error' && $endpoint->current!=null){
                $lstartCursor = $endpoint->current;
            }else{
                $lstartCursor = null;
            }
            
            $l_page = $endpoint->per_page;
            $responseData = $this->callEndpointWithPagination($actualUrl, $endpoint->api_token,$page=$l_page, $lstartCursor,$endpoint->include,$request->id,$modalUrl);

            return response()->json([
                'message' => 'Data Fetched Successfully',
                'endpoint' => $actualUrl,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Endpoint not found'], 404);
        } catch (\Exception $e) {
            $endpoint = Endpoint::findOrFail($request->id);
            $endpoint->status = 'Error';
            $endpoint->save();
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function callEndpointWithPagination($url, $token,$page, $startCursor,$include,$endpoint_id,$modalUrl)
    {
        
        $responseData = [];
        $nextCursor = $startCursor;
      

        do {
            $response = $this->callEndpoint($url, $token, $page, $nextCursor,$include,$endpoint_id);
          

            // $responseData = array_merge($responseData, $response->json('data'));
            // Process the response as needed
            if($modalUrl=='App\Models\Product'){
                $process  = $this->processProduct($response->json('data'),$response->json('meta'),$endpoint_id);
            }else if($modalUrl=='App\Models\Item'){
                $process  = $this->processItems($response->json('data'),$response->json('meta'),$endpoint_id);
            }else if($modalUrl=='App\Models\Category'){
                $process  = $this->processCategory($response->json('data'),$response->json('meta'),$endpoint_id);
            }else{
                $process  = $this->processResponse($response->json('data'),$response->json('meta'),$endpoint_id);
            }
           

            // Check if there is a next cursor
            // print_r($process);
            // dd();
            //sleep(1);
            if($process){
                $nextCursor = $this->getNextCursor($response->json('meta'),$endpoint_id);
            }else{
                $nextCursor =null;
            }
            

        } while ($nextCursor !== null);
        // print_r(count($responseData));
        // print_r($responseData);
        // dd('dfgsg');

        return $responseData;

    }

    private function processCategory($response,$meta,$endpoint_id)
    {
        $endpoint = Endpoint::findOrFail($endpoint_id);
        foreach ($response as $category) {
            // $features  = $product['features']['data'];
            $images    = $category['images']['data'];
            $vehiclemodels = $category['vehiclemodels']['data'];
            // $tags      = $product['tags']['data'];
           // $items     = $product['items']['data'];

            // $p_slug=Str::slug($product['name']);
            if(isset($category['parent_id'])){
                $is_parent= 0;
            }else{
                $is_parent= 1;
            }
            $db_cat = Category::updateOrCreate(
                ['wps_id' => $category['id']],
                [
                    'wps_id' => $category['id'],
                    'vocabulary_id' => $category['vocabulary_id'],
                    'parent_id' => $category['parent_id'],
                    'title' => $category['name'],
                    'slug' => Str::uuid(),
                    'description' => $category['description'],
                    'link' => $category['link'],
                    'link_target_blank' => $category['link_target_blank'],
                    'left' => $category['left'],
                    'right' => $category['right'],
                    'depth' => $category['depth'],
                    'status'=>'active',
                    'is_parent' =>$is_parent
                    // ... other fields
                ]
            );
       
           
            if(count($vehiclemodels)>0){
                foreach ($vehiclemodels as $vehiclemodel) {
                    
                    $VehiclemodelCategory_save = VehiclemodelCategory::updateOrCreate(
                        ['vehiclemodel_id' => $vehiclemodel['vehiclemake_id'],
                        'category_id' => $db_cat->wps_id
                        ],
                        [
                            'category_id' => $db_cat->wps_id,
                            'vehiclemodel_id' => $vehiclemodel['vehiclemake_id'],
                            // ... other fields
                        ]
                    );
                }
            }
            if(count($images)>0){
                foreach ($images as $image) {
                    
                    $product_image_save = CategoryImage::updateOrCreate(
                        ['image_id' => $image['id'],
                        'category_id' => $db_cat->wps_id
                        ],
                        [
                            'category_id' => $db_cat->wps_id,
                            'image_id' => $image['id'],
                            // ... other fields
                        ]
                    );
                }
            }
            
            
        }
    if(isset($meta['cursor']['next'])){
        $endpoint->sync = $meta['cursor']['next'];
        $endpoint->current = $meta['cursor']['current'];
        $endpoint->prev = $meta['cursor']['prev'];
        $endpoint->status = 'Processing';
        $endpoint->save();
        return true;
       
    }else{
        $endpoint->status = 'Completed';
        $endpoint->save();
        return false;
    }
    }

    private function processResponse($response,$meta,$endpoint_id)
    {
        
            $endpoint = Endpoint::findOrFail($endpoint_id);
            foreach ($response as $item) {
                $endpoint->table_name::createRecord($item);
            }
        if(isset($meta['cursor']['next'])){
            $endpoint->sync = $meta['cursor']['next'];
            $endpoint->current = $meta['cursor']['current'];
            $endpoint->prev = $meta['cursor']['prev'];
            $endpoint->status = 'Processing';
            $endpoint->save();
            return true;
           
        }else{
            $endpoint->status = 'Completed';
            $endpoint->save();
            return false;
        }
        
    }

    private function getNextCursor($response,$endpoint_id)
    {
        // Extract the next cursor from the response's meta data
        $meta = $response;
       
        return isset($meta['cursor']['next']) ? $meta['cursor']['next'] : null;
    }

    private function callEndpoint($url, $token, $page, $next = null,$include=null,$endpoint_id)
    {
    set_time_limit(30000);
      //  dd($include);
      $endpoint = Endpoint::findOrFail($endpoint_id);
   
      $timeout = 0;
        if($include){
            if($endpoint->filter){
                $queryParams = ['filter['.$endpoint->filter.']'=>$endpoint->filter_value,'include'=>$include,'page[size]' => $page, 'page[cursor]' => $next];
            }else{
                $queryParams = ['include'=>$include,'page[size]' => $page, 'page[cursor]' => $next];
            }
            
        }else{
            if($endpoint->filter){
                $queryParams = ['filter['.$endpoint->filter.']'=>$endpoint->filter_value,'page[size]' => $page, 'page[cursor]' => $next];
            }else{
                $queryParams = ['page[size]' => $page, 'page[cursor]' => $next];
                
            }
            
        }
        
        $actualUrl = $url . '?' . http_build_query(array_filter($queryParams));

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->timeout($timeout)->get($actualUrl);
        // print_r($actualUrl);
        // dd('dfgsg');
        return $response;
    }


    private function processProduct($response,$meta,$endpoint_id)
    {

    
            $endpoint = Endpoint::findOrFail($endpoint_id);
            foreach ($response as $product) {
                // $features  = $product['features']['data'];
                $images    = $product['images']['data'];
                $resources = $product['resources']['data'];
                $tags      = $product['tags']['data'];
               // $items     = $product['items']['data'];

                $p_slug=Str::slug($product['name']);

                $db_product = Product::updateOrCreate(
                    ['wps_id' => $product['id']],
                    [
                        'wps_id'                => $product['id'],
                        'designation_id'        => $product['designation_id'],
                        'name'                  => $product['name'],
                        'slug'                  => Str::uuid(),
                        'alternate_name'        => $product['alternate_name'],
                        'care_instructions'     => $product['care_instructions'],
                        'description'           => $product['description'],
                        'sort'                  => $product['sort'],
                        'image_360_id'          => $product['image_360_id'],
                        'image_360_preview_id'  => $product['image_360_preview_id'],
                        'size_chart_id'         => $product['size_chart_id'],
                        // ... other fields
                    ]
                );
           
               
                if(count($images)>0){
                                foreach ($images as $image) {
                                   
                                    $product_image_save = ProductImage::updateOrCreate(
                                        ['image_id' => $image['id'],
                                        'product_id' => $db_product->wps_id
                                        ],
                                        [
                                            'product_id' => $db_product->wps_id,
                                            'image_id' => $image['id'],
                                            // ... other fields
                                        ]
                                    );
                                }
                }
                if(count($resources)>0){
                    foreach ($resources as $resource) {
                       
                        $product_resource_save = ProductResource::updateOrCreate(
                            ['resource_id' => $resource['id'],
                            'product_id' => $db_product->wps_id
                            ],
                            [
                                'product_id' => $db_product->wps_id,
                                'resource_id' => $resource['id'],
                                // ... other fields
                            ]
                        );
                    }
                }
                if(count($tags)>0){
                    foreach ($tags as $tag) {
                       
                        $product_tag_save = ProductTag::updateOrCreate(
                            ['tag_id' => $tag['id'],
                            'product_id' => $db_product->wps_id
                            ],
                            [
                                'product_id' => $db_product->wps_id,
                                'tag_id' => $tag['id'],
                                // ... other fields
                            ]
                        );
                    }
                }



            
               
            }
        if(isset($meta['cursor']['next'])){
            $endpoint->sync = $meta['cursor']['next'];
            $endpoint->current = $meta['cursor']['current'];
            $endpoint->prev = $meta['cursor']['prev'];
            $endpoint->status = 'Processing';
            $endpoint->save();
            return true;
           
        }else{
            $endpoint->status = 'Completed';
            $endpoint->save();
            return false;
        }
        
        // Modify this function to process the response as needed
        // $data = $response->json('data');
        // foreach ($data as $item) {
        //     // Process each item in the response
        //     // Example: $item['name'], $item['list_price'], etc.
        // }
    }

    private function processItems($response,$meta,$endpoint_id)
    {

    
            $endpoint = Endpoint::findOrFail($endpoint_id);  
            // print_r($response);
            // die;                 
                    foreach ($response as $item) {
                        // $item_slug=Str::slug($item['name']);
                        //         $count=Category::where('wps_id','!=',$item['id'])->where('slug',$item_slug)->count();
                        //         if($count>0){
                        //             $item_slug=$item_slug.'-'.date('ymdis').'-'.Helper::generateRandomString(4).'-'.$item['id'];
                        //         }
                        $product_item = Item::updateOrCreate(
                            ['wps_id' => $item['id']],
                            [
                                'wps_id' => $item['id'],
                                'brand_id' => $item['brand_id'],
                                'country_id' => $item['country_id'],
                                'product_id' => $item['product_id'],
                                'name' => $item['name'],
                                'slug' => Str::uuid(),
                                'sku' => $item['sku'],
                                'list_price' => $item['list_price'],
                                'standard_dealer_price' => $item['standard_dealer_price'],
                                'supplier_product_id' => $item['supplier_product_id'],
                                'length' => $item['length'],
                                'width' => $item['width'],
                                'height' => $item['height'],
                                'weight' => $item['weight'],
                                'upc' => $item['upc'],
                                'superseded_sku' => $item['superseded_sku'],
                                'status_id' => $item['status_id'],
                                'status' => $item['status'],
                                'unit_of_measurement_id' => $item['unit_of_measurement_id'],
                                'has_map_policy' => $item['has_map_policy'],
                                'sort' => $item['sort'],
                                'product_type' => $item['product_type'],
                                'mapp_price' => $item['mapp_price'],
                                'carb' => $item['carb'],
                                'propd1' => $item['propd1'],
                                'propd2' => $item['propd2'],
                                'prop_65_code' => $item['prop_65_code'],
                                'prop_65_detail' => $item['prop_65_detail'],
                                'drop_ship_fee' => $item['drop_ship_fee'],
                                'drop_ship_eligible' => $item['drop_ship_eligible'],
                                // ... other fields
                            ]
                          
                        );
                        $attributevalues = $item['attributevalues']['data']; // Done
                        $item_images = $item['images']['data']; // Done
                        // $inventory = $item['inventory']['data'];
                        $item_taxonomyterms = $item['taxonomyterms']['data']; // Done
                        $item_vehicles = $item['vehicles']['data'];
                        $item_tags = $item['tags']['data'];// Done
                        if(count($item_tags)>0){
                            foreach ($item_tags as $item_tag) {
                                
                                $product_tem_tag_save = ItemTag::updateOrCreate(
                                    ['tag_id' => $item_tag['id'],
                                    'item_id' => $product_item->wps_id
                                    ],
                                    [
                                        'tag_id' => $item_tag['id'],
                                        'item_id' => $product_item->wps_id,
                                        // ... other fields
                                    ]
                                );
                            }
                        }
                       
                        if(count($item_taxonomyterms)>0){
                            foreach ($item_taxonomyterms as $item_taxonomyterm) {
                              
                                $product_item_item_taxonomyterm_save = ItemCategory::updateOrCreate(
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'category_id' =>$item_taxonomyterm['id'],
                                    ],
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'category_id' => $item_taxonomyterm['id'],
                                        // ... other fields
                                    ]
                                );
                            }
                        }
                        

                        if(count($item_vehicles)>0){
                            foreach ($item_vehicles as $item_vehicle) {
                               
                                $item_vehicle_data_save = ItemVehicle::updateOrCreate(
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'vehicle_id' => $item_vehicle['id'],
                                    ],
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'vehicle_id' => $item_vehicle['id'],
                                        // ... other fields
                                    ]
                                );
                           
                            }
                        }
                       
                        if(count($item_images)>0){
                            foreach ($item_images as $tem_image) {
                              
                                $product_item_image_save = ItemImage::updateOrCreate(
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'image_id' => $tem_image['id'],
                                    ],
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'image_id' => $tem_image['id'],
                                        // ... other fields
                                    ]
                                );
                            }
                        }
                       
                        if(count($attributevalues)>0){
                            foreach ($attributevalues as $attributevalue) {
                               
                                $product_item_attributevalue_save = ItemAttributevalue::updateOrCreate(
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'attributevalue_id' => $attributevalue['id'],
                                    ],
                                    [
                                        'item_id' => $product_item->wps_id,
                                        'attributevalue_id' => $attributevalue['id'],
                                        // ... other fields
                                    ]
                                );
                            }
                        }
                        // dd('sdfssdf11');
                       
                        // dd('I am here');
                    }
               
        if(isset($meta['cursor']['next'])){
            $endpoint->sync = $meta['cursor']['next'];
            $endpoint->current = $meta['cursor']['current'];
            $endpoint->prev = $meta['cursor']['prev'];
            $endpoint->status = 'Processing';
            $endpoint->save();
            return true;
           
        }else{
            $endpoint->status = 'Completed';
            $endpoint->save();
            return false;
        }
        
       
    }


      
    
    
}
