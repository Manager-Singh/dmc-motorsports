<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attributevalue;
use App\Models\Item;
use App\Models\Inventory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\Vehiclemake;
use App\Models\Vehiclemodel;
use App\Models\Vehicleyear;
use App\Models\ItemAttributevalue;
use App\Models\ItemVehicle;
use App\Models\ItemCategory;
use App\Models\ItemImage;
use App\Models\Image;

use App\Models\VehiclemodelCategory;
use DB;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products= Item::with(['images','brand','categories','inventory']) ->where(function ($query) {
            $term = '%' . request('term') . '%';
            $query->where('name', 'like', trim($term))
                  ->orWhere('sku', 'like', trim($term));
        })->orderBy('wps_id', 'desc')->paginate(10);
        $pagination = $products->appends ( array (
            'term' => trim(request('term')),
          ) );

        // print_r($products);
        // die;
        // return $products;
        return view('backend.product.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand=Brand::get();
        $categories=Category::pluck('title','wps_id');
        $attributevalues=Attributevalue::get();
        $product_type = Item::distinct()->pluck('product_type')->toArray();
        
        return view('backend.product.create')
                    ->with('brands',$brand)
                    ->with('attributevalues',$attributevalues)
                    ->with('product_type',$product_type)
                    ->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // print_r(genrateWpsId());
        // die;

    
        //return $request->photo;
        $this->validate($request,[
            'name'=>'string|required',
            'description'=>'string|nullable',
            'stock'=>"required|numeric",
            'brand_id'=>'nullable|exists:brands,wps_id',
            'status'=>'required|in:STK,SPEC,PRE,NEW,DIR,DSC,CLO,NA,NLA',
            'price'=>'required|numeric',
            'photo'=>'string|nullable',
            'product_type'=>'required',
            'sku'=>'required|unique:items,sku'
            
        ]);


        // $data=$request->all();
        $slug=Str::slug($request->title);
        $item_wps_id = genrateWpsId();
        $item_data=[
            'name'=>$request->name,
            'description'=>$request->description,
            'list_price'=>$request->price,
            'status'=>$request->status,
            'brand_id'=>$request->brand_id,
            'sku'=>$request->sku,
            'slug'=> Str::uuid(),
            'wps_id'=>$item_wps_id,
            'type'=>'custom',
            'has_map_policy'=>0,
            'drop_ship_eligible'=>0,
            'product_type'=>$request->product_type
            
        ];
        

             //  $status=$item->fill($item_data)->save();
        $status=Item::create($item_data);
          if($status ){
            $id = $item_wps_id;
            if($request->stock){
                $inventory = Inventory::where('item_id',$id)->first();
                if($inventory){
                    $inventory->total = $request->stock;
                    $inventory->save();
                }else{
                    
                    $inventory_data=[
                        'wps_id'=>genrateWpsId(),
                        'item_id'=> $id,
                        'total'=>$request->stock,
                    ];
                    Inventory::create($inventory_data);
                }
            }
                if($request->photo){
                    $photos = explode(',',$request->photo);
                    foreach($photos as $photo){
                    $image_wps_id = genrateWpsId();
                    $pathInfo = pathinfo($photo);
                    $domain = request()->getHost();
            
                    // Get the file name and directory separately
                    $fileName = $pathInfo['basename']; // file name with extension
                    $directory = $pathInfo['dirname']; // directory path
            

                    $image_data=[
                        'filename'=>$fileName,
                        'path'=> $directory,
                        'wps_id'=>$image_wps_id,
                        'domain'=>$domain,
                        
                    ];
                    $immg=Image::create($image_data);
                    if($immg){
                        $image_item_data=[
                            'item_id'=>$id,
                            'image_id'=> $image_wps_id,                        
                        ];

                        ItemImage::create($image_item_data);
                    }
                }
                
                }
                if(isset($request->attributevalues)){
                    ItemAttributevalue::where('item_id',$id)->delete();
                    foreach($request->attributevalues as $attribute){
                        
        
                        $product_item_attributevalue_save = ItemAttributevalue::updateOrCreate(
                            [
                                'item_id' => $id,
                                'attributevalue_id' => $attribute,
                            ],
                            [
                                'item_id' => $id,
                                'attributevalue_id' => $attribute,
                                // ... other fields
                            ]
                        );
                    }
                }
                if(isset($request->categories)){
                    ItemCategory::where('item_id',$id)->delete();
                    foreach($request->categories as $categorie){
                        $product_item_item_taxonomyterm_save = ItemCategory::updateOrCreate(
                            [
                                'item_id' => $id,
                                'category_id' =>$categorie,
                            ],
                            [
                                'item_id' => $id,
                                'category_id' => $categorie,
                                // ... other fields
                            ]
                        );
                    }
                }
                    
                    request()->session()->flash('success','Product Successfully Create');
                   
                    
                }
                else{
                    request()->session()->flash('error','Please try again!!');
                }
                return redirect()->route('product.index');
        
       

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $brand=Brand::get();
        $categories=Category::pluck('title','wps_id');
        $attributevalues=Attributevalue::get()->toArray();
        

        $items=Item::with('product','images','inventory','categories','attributevalues','vehicles')->where('wps_id',$id)->first();
        //  print_r($items->attributevalues->toArray());
        
        // $vehicles=Vehicle::whereIn('wps_id',)->get();
        // print_r($vehicles);
       // die;
        // return $items;
        return view('backend.product.edit')->with('product',$items)
                    ->with('brands',$brand)
                    ->with('attributevalues',$attributevalues)
                    ->with('categories',$categories);
    }

    public function productVehicle($id)
    {
        $items=Item::with('product','images','inventory','categories','attributevalues','vehicles','vehicles.vehiclemodel','vehicles.vehicleyear','vehicles.vehiclemodel.vehiclemake','vehicles.vehiclemodel.categories')->where('wps_id',$id)->first();
         //print_r($items->vehicles->pluck('wps_id'));
        
       $vehicles=Vehicle::with('vehiclemodel','vehicleyear','vehiclemodel.vehiclemake')->paginate(12);
        // print_r($fcategories);
        // die;
        // return $items;
        return view('backend.product.vehicle')->with('product',$items)
                    ->with('vehicles',$vehicles);
    }

    public function attachproductVehicle(Request $request)
    {
    // print_r($request->vehicle_items);
    // die;

      foreach($request->vehicle_items as $vehicle){
        $item_vehicle_data_save = ItemVehicle::updateOrCreate(
            [
                'item_id' => $request->item_id,
                'vehicle_id' => $vehicle,
            ],
            [
                'item_id' => $request->item_id,
                'vehicle_id' => $vehicle,
                // ... other fields
            ]
        );
      }
     // request()->session()->flash('success','vehicles attached with item Successfully');
      return redirect()->back()->with('success','vehicles attached with item Successfully');
    }
    
    public function deleteproductVehicle(Request $request)
    {
    
    if(ItemVehicle::where('item_id',$request->item_id)->where('vehicle_id',$request->vehicle_id)->delete()){
        return true;
    }
     return false;
      //ItemVehicle
     // request()->session()->flash('success','vehicles attached with item Successfully');
     // return redirect()->back()->with('success','Attached vehicle deleted Successfully');
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // print_r($id);
        //print_r($request->photo);
        // print_r($request->attributevalues);
        // die;
     
        $item=Item::findOrFail($id);
        // print_r($item->images);
        // die;
     
        if($request->type=='wps'){
            $product=Product::findOrFail($request->product_wps_id);
        }
       
        // $inventory = Inventory::where('item_id',$id)->first();
        // print_r($item);
        // print_r($product);
        //  die;
        $this->validate($request,[
            'name'=>'string|required',
            'description'=>'string|nullable',
            'stock'=>"required|numeric",
            'brand_id'=>'nullable|exists:brands,wps_id',
            'status'=>'required|in:STK,SPEC,PRE,NEW,DIR,DSC,CLO,NA,NLA',
            'price'=>'required|numeric',
            'sku' => [
                'required',
                Rule::unique('items', 'sku')->ignore($id, 'wps_id'),
            ],
        ]);

        $item_data=['name'=>$request->name,'list_price'=>$request->price,'status'=>$request->status,'brand_id'=>$request->brand_id,'sku'=>$request->sku];
        if($request->type=='wps'){
        $product_data=['description'=>$request->description];
        }
        if($request->type=='wps'){
            $item_data['description']=$request->description;
        }
        // $inventory->total = $request->stock;
        
    
        // return $data;
        $status=$item->fill($item_data)->save();
        if($request->type=='wps'){
        $statusp=$product->fill($product_data)->save();
        }
        if($status){
            if($request->stock){
                $inventory = Inventory::where('item_id',$id)->first();
                if($inventory){
                    $inventory->total = $request->stock;
                    $inventory->save();
                }else{
                    
                    $inventory_data=[
                        'wps_id'=>genrateWpsId(),
                        'item_id'=> $id,
                        'total'=>$request->stock,
                    ];
                    Inventory::create($inventory_data);
                }
            }

            if($request->photo){
                // if(isset($item->images[0])){     

                    
                //     $pathInfo = pathinfo($request->photo);
                //     $domain = request()->getHost();
            
                //     // Get the file name and directory separately
                //     $fileName = $pathInfo['basename']; // file name with extension
                //     $directory = $pathInfo['dirname']; // directory path
            
                //     if($item->images[0]->filename != $fileName || $item->images[0]->path != $directory ){
                       
                //         $immgg=Image::where('wps_id',$item->images[0]->wps_id)->first(); 
                //         $immgg->domain = $domain;
                //         $immgg->path = $directory;
                //         $immgg->filename = $fileName;
                //         $immgg->save();
                //     }
                    

                // }else{
                    $photos = explode(',',$request->photo);
                    ItemImage::where('item_id',$id)->delete();
                    foreach($photos as $photo){
                    $image_wps_id = genrateWpsId();
                    $pathInfo = pathinfo($photo);
                    $domain = request()->getHost();
            
                    // Get the file name and directory separately
                    $fileName = $pathInfo['basename']; // file name with extension
                    $directory = $pathInfo['dirname']; // directory path
            
    
                    $image_data=[
                        'filename'=>$fileName,
                        'path'=> $directory,
                        'wps_id'=>$image_wps_id,
                        'domain'=>$domain,
                        
                    ];
                    $immg=Image::create($image_data);
                    if($immg){
                        $image_item_data=[
                            'item_id'=>$id,
                            'image_id'=> $image_wps_id,                        
                        ];
    
                        ItemImage::create($image_item_data);
                    }
                }
                // }
               
                
            
            }
            if(isset($request->attributevalues)){
            ItemAttributevalue::where('item_id',$id)->delete();
            foreach($request->attributevalues as $akey=>$attribute){
                
                $product_item_attributevalue_save = ItemAttributevalue::create([
                    'item_id' => $id,
                    'attributevalue_id' => $attribute,
                    // ... other fields
                ]);
                // $product_item_attributevalue_save = ItemAttributevalue::updateOrCreate(
                //     [
                //         'item_id' => $id,
                //         'attributevalue_id' => $attribute,
                //     ],
                //     [
                //         'item_id' => $id,
                //         'attributevalue_id' => $attribute,
                //         // ... other fields
                //     ]
                // );
            }
        }
        if(isset($request->categories)){
            ItemCategory::where('item_id',$id)->delete();
            foreach($request->categories as $categorie){
                $product_item_item_taxonomyterm_save = ItemCategory::updateOrCreate(
                    [
                        'item_id' => $id,
                        'category_id' =>$categorie,
                    ],
                    [
                        'item_id' => $id,
                        'category_id' => $categorie,
                        // ... other fields
                    ]
                );
            }
        }
            
            request()->session()->flash('success','Product Successfully updated');
           
            
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
    }

    public function updateImages($wps_id){
        $curl = curl_init();

// Initial cursor value
$cursor = null;

    do {
        $url = "https://api.wps-inc.com/items/".$wps_id."/images";
        // Append cursor to the URL if available
        if ($cursor) {
            $url .= "?page[cursor]=" . $cursor;
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer zNsW6dBeTgHS4qk0AEnbO86ibp5jrmPUYUJDNagE",
                "User-Agent: insomnia/8.4.5"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
            break;
        } else {
            // Handle the response
            $cresponse = json_decode($response);
            //print_r($cresponse);
            //die;
            if ($cresponse) {
                if (count($cresponse->data) > 0) {
                    foreach ($cresponse->data as $image) {
                        $imagefound = Image::where('wps_id', $image->id)->first();
                        if (!$imagefound) {
                            Image::createRecord((array)$image);
                        }
                        ItemImage::where('item_id', $wps_id)->delete();
                        // if (ItemImage::where('item_id', $wps_id)->delete()) {
                            ItemImage::create([
                                'item_id' => $wps_id,
                                'image_id' => $image->id
                            ]);
                        // }
                    }
                }
            }

            // Extract pagination information from the response
            $json_response = json_decode($response, true);
            $cursor = $json_response['meta']['cursor']['next'] ?? null;
            
        }
    } while ($cursor); // Continue fetching next pages until no more cursor is available

    curl_close($curl);
    return redirect()->back()->with('success','Images attached with item Successfully');

    }
    public function updateVehicles($wps_id){
        $item_v_count = ItemVehicle::where('item_id',$wps_id)->count();
        if($item_v_count>0){
            ItemVehicle::where('item_id',$wps_id)->delete();
        }
        
        $curl = curl_init();

        // Initial cursor value
        $cursor = null;
        
        do {
            $url = "https://api.wps-inc.com/items/".$wps_id."/vehicles";
            // Append cursor to the URL if available
            if ($cursor) {
                $url .= "?page[cursor]=" . $cursor;
            }
        
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer zNsW6dBeTgHS4qk0AEnbO86ibp5jrmPUYUJDNagE",
                    "User-Agent: insomnia/8.4.5"
                ],
            ]);
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
        
            if ($err) {
                echo "cURL Error #:" . $err;
                break;
            } else {
                // Handle the response
                $vresponse = json_decode($response);
                // print_r($vresponse->data[0]->id);
                // die;
                if ($vresponse) {
                    if (count($vresponse->data) > 0) {
                        foreach ($vresponse->data as $vehicle) {
                           
                            ItemVehicle::updateOrCreate(
                                [
                                    'item_id' => $wps_id,
                                    'vehicle_id' => $vehicle->id,
                                ],
                                [
                                    'item_id' => $wps_id,
                                    'vehicle_id' => $vehicle->id,
                                    // ... other fields
                                ]
                            );

                        }
                    }
                }

                // Extract pagination information from the response
                $json_response = json_decode($response, true);
                $cursor = $json_response['meta']['cursor']['next'] ?? null;
                // print_r($cursor);
                // die;
            }
        } while ($cursor); // Continue fetching next pages until no more cursor is available
        
        curl_close($curl);
        return redirect()->back()->with('success','vehicle attached with item Successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
