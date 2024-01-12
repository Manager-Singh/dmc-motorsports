<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\Vehiclemake;
use App\Models\Vehiclemodel;
use App\Models\Vehicle;
use App\Models\ItemVehicle;
use App\Models\Vehicleyear;
use App\Models\Item;
use App\Models\VehiclemodelCategory;
use App\Models\ItemCategory;
use App\Models\Attributevalue;
use App\User;
use Auth;
use Session;
use Newsletter;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class FrontendController extends Controller
{
   
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }

    public function home(){
        $featured=Product::has('items')->with(['photo','items','items.images'])->where('status','active')->where('is_featured',1)->orderBy('sort','DESC')->limit(2)->get();
        $posts=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $banners=Banner::where('status','active')->limit(3)->orderBy('id','DESC')->get();
        // return $banner;
        $products=Product::has('items')->with(['photo','items','items.images'])->where('status','active')->orderBy('id','DESC')->limit(8)->get();
        $category=Category::has('items')->with(['images.image'])->where('status','active')->where('is_parent',1)->orderBy('title','ASC')->paginate(6);
        $product_lists=Product::has('items')->with(['photo','items','items.images'])->where('status','active')->orderBy('id','DESC')->limit(6)->get();
        $category_banner_lists=Category::has('items')->with(['images.image'])->where('status','active')->where('is_parent',1)->inRandomOrder()->limit(3)->get();
        $Vehiclemake=Vehiclemake::pluck('name', 'wps_id')->all();
        $vehicle_model_categories = VehiclemodelCategory::with('category')->select('category_id', DB::raw('COUNT(*) as category_count'))
        ->groupBy('category_id')
        ->get();
        
        
        // // return $category;
        // print_r( $vehicle_model_categories);
        // die;
        return view('frontend.index')
                ->with('featured',$featured)
                ->with('posts',$posts)
                ->with('banners',$banners)
                ->with('product_lists',$products)
                ->with('all_category_lists',$category)
                ->with('category_banner_lists',$category_banner_lists)
                ->with('vehiclemakes',$Vehiclemake)
                ->with('vehicle_model_categories',$vehicle_model_categories)
                ->with('product_lists',$product_lists);
    }   
    
    public function nhome(){
        $vehicle_model_categories = VehiclemodelCategory::with('category')->select('category_id', DB::raw('COUNT(*) as category_count'))
        ->groupBy('category_id')
        ->get();
        
        return view('frontend.new-index')->with('vehicle_model_categories',$vehicle_model_categories);
    }
    public function loadMore(Request $request)
    {
        // Get the current page from the request
        $page = $request->input('page', 1);

        // Fetch more products based on the page
        $all_category_lists = Category::has('items')->with(['images.image'])->where('status','active')->where('is_parent',1)->orderBy('title','ASC')->paginate(6, ['*'], 'page', $page);

        // Return the HTML for the new products
        return view('frontend.partials.categories', compact('all_category_lists'))->render();
    }
    
    public function getVehicleMakesCategories(Request $request)
    {
      

        $vcatId = $request->input('vcatId');
       

        // VehiclemodelCategory
        // Fetch the models based on the selected car maker
        // $models = Vehiclemodel::where('vehiclemake_id',$carMakerId)->pluck('name', 'wps_id')->all();
       $vehiclemodel_ids =  VehiclemodelCategory::where('category_id',$vcatId)->pluck('vehiclemodel_id')->all();
       $vehiclemodel_ids = array_unique($vehiclemodel_ids);
       
        $Vehiclemake=Vehiclemake::whereIn('wps_id', $vehiclemodel_ids)->pluck('name', 'wps_id')->all();
    //     print_r($Vehiclemake);
    //    die;
    // Prepare the HTML options for the model dropdown
    $options = '';
    foreach ($Vehiclemake as $wps=>$make) {
        $options .= '<option value="' . $wps . '">' . $make . '</option>';
    }

    // Return the options as JSON
    return response()->json(['options' => $options]);
    }
    public function getVehicleModels(Request $request)
    {
        // Get the car maker ID from the request
        $carMakerId = $request->input('carMakerId');

        // Fetch the models based on the selected car maker
        $models = Vehiclemodel::where('vehiclemake_id',$carMakerId)->pluck('name', 'wps_id')->all();

        // Prepare the HTML options for the model dropdown
        $options = '';
        foreach ($models as $wps=>$model) {
            $options .= '<option value="' . $wps . '">' . $model . '</option>';
        }

        // Return the options as JSON
        return response()->json(['options' => $options]);
    }
    public function getVehicleModelYears(Request $request)
    {
        // Get the car maker ID from the request
        $carModelId = $request->input('carModelId');

        // Fetch the models based on the selected car maker
        $models = Vehicle::with(['vehicleyear'])->where('vehiclemodel_id',$carModelId)->get();
        $vehicleYears = $models->mapWithKeys(function ($vehicle) {
            return [$vehicle->vehicleyear->wps_id => $vehicle->vehicleyear->name];
        })->toArray();
        // print_r($vehicleYears);
        // die;
        // Prepare the HTML options for the model dropdown
        $options = '';
        foreach ($vehicleYears as $wps=>$year) {
            $options .= '<option value="' . $wps . '">' . $year . '</option>';
        }

        // Return the options as JSON
        return response()->json(['options' => $options]);
    }
    
    
    public function searchItems(Request $request)
    {
        if($request->isMethod('post')){
            
        $vehicle_category = $request->vehicle_category;
        $vehicle_maker = $request->vehicle_maker;
        $vehicle_model = $request->vehicle_model;
        $vehicle_year = $request->vehicle_year;
    
        $query = Vehicle::with(['vehicleyear', 'vehiclemodel', 'items', 'items.brand', 'items.country', 'items.categories']);
    
        if ($vehicle_model) {
            $query->where('vehiclemodel_id', $vehicle_model);
        }
    
        if ($vehicle_year) {
            $query->where('vehicleyear_id', $vehicle_year);
        }
    
        $vehicles = $query->pluck('wps_id');
        $allItems = ItemVehicle::has('item')->with(['item', 'item.brand', 'item.country', 'item.categories'])->whereIn('vehicle_id', $vehicles)->paginate(12);
        $vehicle_model_categories = VehiclemodelCategory::with('category')->select('category_id', DB::raw('COUNT(*) as category_count'))
        ->groupBy('category_id')
        ->get();

        $cat_name = Category::where('wps_id',$vehicle_category)->first()->title;
        $v_make_name = Vehiclemake::where('wps_id',$vehicle_maker)->first()->name;
        $v_model_name = Vehiclemodel::where('wps_id',$vehicle_model)->first()->name;
        $v_year_name = Vehicleyear::where('wps_id',$vehicle_year)->first()->name;

        $search_bred =''; 
        $search_bred .= '<li>'.$cat_name.'<i class="ti-arrow-right"></i></li>';
        $search_bred .= '<li>'.$v_make_name.'<i class="ti-arrow-right"></i></li>';
        $search_bred .= '<li>'.$v_model_name.'<i class="ti-arrow-right"></i></li>';
        $search_bred .= '<li>'.$v_year_name.'</li>';
        return view('frontend.search-items')
        ->with('vehicle_maker', $vehicle_maker)
        ->with('vehicle_model', $vehicle_model)
        ->with('vehicle_year', $vehicle_year)
        ->with('vehicle_model_categories',$vehicle_model_categories)
        ->with('search_bred',$search_bred)
        ->with('allItems', $allItems);
       
    }else{
        $page=$request->page;
        $vehicle_maker = $request->vehicle_maker;
        $vehicle_model = $request->vehicle_model;
        $vehicle_year = $request->vehicle_year;
    
        $query = Vehicle::with(['vehicleyear', 'vehiclemodel', 'items', 'items.brand', 'items.country', 'items.categories']);
    
        if ($vehicle_model) {
            $query->where('vehiclemodel_id', $vehicle_model);
        }
    
        if ($vehicle_year) {
            $query->where('vehicleyear_id', $vehicle_year);
        }
    
        $vehicles = $query->pluck('wps_id');
        $allItems = ItemVehicle::has('item')->with(['item', 'item.brand', 'item.country', 'item.categories'])->whereIn('vehicle_id', $vehicles)->paginate(12, ['*'], 'page', $page);
        // print_r($allItems);
        if($allItems){
            return view('frontend.partials.vechile-items', compact('allItems'))->render();
        }else{
            return "";
        }
        

    }
    
       
    }

    public function aboutUs(){
        return view('frontend.pages.about-us');
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function productDetail($slug){
        $product_detail= Item::getProductBySlug($slug);
        // print_r($product_detail);
        // die;
        // dd($product_detail);
        return view('frontend.pages.product_detail')->with('product_detail',$product_detail);
    }

    public function productGrids(){
        $products=Item::query()->with('images');
        
        // print_r($products);
        // die;
        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id',$cat_ids);
            // return $products;
        }
        if(!empty($_GET['brand'])){
            $slugs=explode(',',$_GET['brand']);
            $brand_ids=Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id',$brand_ids);
        }
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $products=$products->where('status','!=','NLA')->orderBy('name','ASC');
            }
            if($_GET['sortBy']=='price'){
                $products=$products->orderBy('list_price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
            
            $products->whereBetween('list_price',$price);
        }

        $recent_products=Item::with('images')->where('status','!=','NLA')->orderBy('id','DESC')->limit(3)->get();
        // Sort by number
        if(!empty($_GET['show'])){
            $products=$products->where('status','!=','NLA')->paginate($_GET['show']);
        }
        else{
            $products=$products->where('status','!=','NLA')->paginate(9);
        }
        // Sort by name , price, category
//  print_r($products);
//         die;
        $brands=Brand::has('items')->orderBy('title','ASC')->where('status','active')->get();
        return view('frontend.pages.product-grids')->with('brands',$brands)->with('products',$products)->with('recent_products',$recent_products);
    }
    public function productLists(){
        $products=Item::query()->with('images');
        
        
        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id',$cat_ids)->paginate(9);
            // return $products;
        }
        if(!empty($_GET['brand'])){
            $slugs=explode(',',$_GET['brand']);
            $brand_ids=Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id',$brand_ids);
        }
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $products=$products->orderBy('title','ASC');
            }
            if($_GET['sortBy']=='price'){
                $products=$products->orderBy('list_price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
            
            $products->whereBetween('price',$price);
        }

        $recent_products=Item::with('images')->where('status','!=','NLA')->orderBy('id','DESC')->limit(3)->get();
        // Sort by number
        if(!empty($_GET['show'])){
            $products=$products->where('status','!=','NLA')->paginate($_GET['show']);
        }
        else{
            $products=$products->where('status','!=','NLA')->paginate(6);
        }
        // Sort by name , price, category

      
        return view('frontend.pages.product-lists')->with('products',$products)->with('recent_products',$recent_products);
    }
    public function productFilter(Request $request){
            $data= $request->all();
            // return $data;
            $showURL="";
            if(!empty($data['show'])){
                $showURL .='&show='.$data['show'];
            }

            $sortByURL='';
            if(!empty($data['sortBy'])){
                $sortByURL .='&sortBy='.$data['sortBy'];
            }

            $catURL="";
            if(!empty($data['category'])){
                foreach($data['category'] as $category){
                    if(empty($catURL)){
                        $catURL .='&category='.$category;
                    }
                    else{
                        $catURL .=','.$category;
                    }
                }
            }

            $brandURL="";
            if(!empty($data['brand'])){
                foreach($data['brand'] as $brand){
                    if(empty($brandURL)){
                        $brandURL .='&brand='.$brand;
                    }
                    else{
                        $brandURL .=','.$brand;
                    }
                }
            }
            // return $brandURL;

            $priceRangeURL="";
            if(!empty($data['price_range'])){
                $priceRangeURL .='&price='.$data['price_range'];
            }
            return redirect()->route('product-grids',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
            // if(request()->is('e-shop.loc/product-grids')){
            //     return redirect()->route('product-grids',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
            // }
            // else{
            //     return redirect()->route('product-lists',$catURL.$brandURL.$priceRangeURL.$showURL.$sortByURL);
            // }
    }
    public function productSearch(Request $request){
       
        $recent_products=Item::where('status','New')->orderBy('id','DESC')->limit(3)->get();
        $products=Item::with('images')
                    ->orwhere('name','like','%'.$request->search.'%')
                    ->orwhere('list_price','like','%'.$request->search.'%')
                    ->orderBy('id','DESC')
                    ->paginate('9');
                    $pagination = $products->appends ( array (
                        'search' => $request->search 
                      ) );
        $brands=Brand::has('items')->orderBy('title','ASC')->where('status','active')->get();
        return view('frontend.pages.product-grids')->with('brands',$brands)->with('products',$products)->with('recent_products',$recent_products)->withQuery ( $request->search );
    }

    public function productBrand(Request $request){
        $products=Item::with('images')->where('brand_id', $request->slug)
        ->orderBy('id','DESC')
        ->paginate('9');

        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $brands=Brand::has('items')->orderBy('title','ASC')->where('status','active')->get();
        return view('frontend.pages.product-grids')->with('brands',$brands)->with('products',$products)->with('recent_products',$recent_products);
        // if(request()->is('e-shop.loc/product-grids')){
        //     return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        // }
        // else{
        //     return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        // }

    }
    public function productCat(Request $request){
        
        $items_ids =  ItemCategory::where('category_id',$request->wps_id)->pluck('item_id')->all();
        $items_ids = array_unique($items_ids);
        $items = Item::with('images')->whereIn('wps_id', $items_ids)
                    ->orderBy('id','DESC')
                    ->paginate('9');
        
        // print_r($items);
        // die;
        // return $request->slug;
        $brands=Brand::has('items')->orderBy('title','ASC')->where('status','active')->get();
        $recent_products=Item::with('images')->where('status','NEW')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.product-grids')->with('brands',$brands)->with('products',$items)->with('recent_products',$recent_products);
        // if(request()->is('e-shop.loc/product-grids')){
        //     return view('frontend.pages.product-grids')->with('products',$items)->with('recent_products',$recent_products);
        // }
        // else{
        //     return view('frontend.pages.product-lists')->with('products',$items)->with('recent_products',$recent_products);
        // }

    }
    
    public function newProductCat(Request $request){
        $attributevalues = Attributevalue::has('items')->where('attributekey_id',1)->get();
        $category = Category::where('wps_id',$request->wps_id)->first();
       
        return view('frontend.pages.product-types')->with('category',$category)->with('attributevalues',$attributevalues);
    }

    
    public function productTypesByCat(Request $request){
        $categoryId = $request->cat_id;
    

        $items = Item::with('images')->whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.wps_id', $categoryId);
        })->where('product_type', $request->name)->paginate('12');
        
        $brands=Brand::has('items')->orderBy('title','ASC')->where('status','active')->get();
        $recent_products=Item::with('images')->where('status','NEW')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.product-grids')->with('brands',$brands)->with('products',$items)->with('recent_products',$recent_products);
    }
    public function productSubCat(Request $request){
       
        $items_ids =  ItemCategory::where('category_id',$request->sub_slug)->pluck('item_id')->all();
        $items_ids = array_unique($items_ids);
        // print_r($items_ids);
        // die;
        $items = Item::with('images')->whereIn('wps_id', $items_ids)
                    ->orderBy('id','DESC')
                    ->paginate('9');
                    $brands=Brand::has('items')->orderBy('title','ASC')->where('status','active')->get();
        $recent_products=Item::with('images')->where('status','NEW')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.product-grids')->with('brands',$brands)->with('products',$items)->with('recent_products',$recent_products);
        // if(request()->is('e-shop.loc/product-grids')){
        //     return view('frontend.pages.product-grids')->with('products',$items)->with('recent_products',$recent_products);
        // }
        // else{
        //     return view('frontend.pages.product-lists')->with('products',$items)->with('recent_products',$recent_products);
        // }

    }

    public function blog(){
        $post=Post::query();
        
        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=PostCategory::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id',$cat_ids);
            // return $post;
        }
        if(!empty($_GET['tag'])){
            $slug=explode(',',$_GET['tag']);
            // dd($slug);
            $tag_ids=PostTag::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id',$tag_ids);
            // return $post;
        }

        if(!empty($_GET['show'])){
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate($_GET['show']);
        }
        else{
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogDetail($slug){
        $post=Post::getPostBySlug($slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogSearch(Request $request){
        // return $request->all();
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $posts=Post::orwhere('title','like','%'.$request->search.'%')
            ->orwhere('quote','like','%'.$request->search.'%')
            ->orwhere('summary','like','%'.$request->search.'%')
            ->orwhere('description','like','%'.$request->search.'%')
            ->orwhere('slug','like','%'.$request->search.'%')
            ->orderBy('id','DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts',$posts)->with('recent_posts',$rcnt_post);
    }

    public function blogFilter(Request $request){
        $data=$request->all();
        // return $data;
        $catURL="";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($catURL)){
                    $catURL .='&category='.$category;
                }
                else{
                    $catURL .=','.$category;
                }
            }
        }

        $tagURL="";
        if(!empty($data['tag'])){
            foreach($data['tag'] as $tag){
                if(empty($tagURL)){
                    $tagURL .='&tag='.$tag;
                }
                else{
                    $tagURL .=','.$tag;
                }
            }
        }
        // return $tagURL;
            // return $catURL;
        return redirect()->route('blog',$catURL.$tagURL);
    }

    public function blogByCategory(Request $request){
        $post=PostCategory::getBlogByCategory($request->slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post->post)->with('recent_posts',$rcnt_post);
    }

    public function blogByTag(Request $request){
        // dd($request->slug);
        $post=Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data= $request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>'active'])){
            Session::put('user',$data['email']);
            request()->session()->flash('success','Successfully login');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Logout successfully');
        return back();
    }

    public function register(){
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request){
        // return $request->all();
        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email'=>'string|required|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);
        $data=$request->all();
        // dd($data);
        $check=$this->create($data);
        Session::put('user',$data['email']);
        if($check){
            request()->session()->flash('success','Successfully registered');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Please try again!');
            return back();
        }
    }
    public function create(array $data){
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'status'=>'active'
            ]);
    }
    // Reset password
    public function showResetForm(){
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request){
        if(! Newsletter::isSubscribed($request->email)){
                Newsletter::subscribePending($request->email);
                if(Newsletter::lastActionSucceeded()){
                    request()->session()->flash('success','Subscribed! Please check your email');
                    return redirect()->route('home');
                }
                else{
                    Newsletter::getLastError();
                    return back()->with('error','Something went wrong! please try again');
                }
            }
            else{
                request()->session()->flash('error','Already Subscribed');
                return back();
            }
    }
    
}
