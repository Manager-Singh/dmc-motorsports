<?php
use App\Models\Message;
use App\Models\Category;
use App\Models\Attributekey;
use App\Models\Attributevalue;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Item;
use App\Models\VehiclemodelCategory;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
// use Auth;
class Helper{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    } 
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    } 
    
    public static function getItemCount($categoryId,$product_type){
        $items_count = Item::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.wps_id', $categoryId);
        })->where('product_type', $product_type)->count();
        return $items_count;
    }
    public static function getHeaderAttributeValues($id = 1){
        $attributevalues = Attributevalue::has('items')->where('attributekey_id',$id)->get();
        // $vehicle_model_categories = VehiclemodelCategory::with('category')->select('category_id', DB::raw('COUNT(*) as category_count'))
        // ->groupBy('category_id')
        // ->get();

        $categories = Category::has('items')->where('status','active')->where('is_parent',1)->orderBy('title','ASC')->get();
    



// print_r($items);
// die;
      
        if($categories){
            ?>
            
            <li>
            <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($categories as $cat_info){
                        $categoryId = $cat_info->wps_id;
                        $main_counter = 0;
                        
                        ?>
                            <li><a href="<?php echo route('new-product-cat',$cat_info->wps_id); ?>"><?php echo $cat_info->title; ?></a>
                               
                            </li>
                            <?php
                         
                        }
                   
                    ?>
                </ul>
            </li>
        <?php
        }
    }
    public static function getHeaderCategory(){
        $category = new Category();
        // dd($category);
        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>
            
            <li>
            <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        
                            if($cat_info->child_cat->count()>0){
                                // $count_sub_catmain=DB::table('item_categories')->where('category_id',$cat_info->wps_id)->count();
                                $childWpsIds = $cat_info->child_cat->pluck('wps_id');
                                
                                $count_sub_catmain=DB::table('item_categories')->whereIn('category_id',$childWpsIds)->count();
                                // dd($count_sub_catmain);
                             if($count_sub_catmain>0){
                               
                            ?>
                            <li><a href="<?php echo route('product-cat',$cat_info->wps_id); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    
                                    foreach($cat_info->child_cat as $sub_menu){
                                        $count_sub_cat=DB::table('item_categories')->where('category_id',$sub_menu->wps_id)->count();
                                        if($count_sub_cat>0){
                                        ?>
                                        <li><a href="<?php echo route('product-sub-cat',[$cat_info->wps_id,$sub_menu->wps_id]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                    }
                        else{
                            ?>
                                <li><a href="<?php echo route('product-cat',$cat_info->wps_id);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    public static function postTagList($option='all'){
        if($option='all'){
            return PostTag::orderBy('id','desc')->get();
        }
        return PostTag::has('posts')->orderBy('id','desc')->get();
    }

    public static function postCategoryList($option="all"){
        if($option='all'){
            return PostCategory::orderBy('id','DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id','DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
        }
        else{
            return Cart::where('guest_id',request()->session()->get('guest_id'))->where('order_id',null)->sum('quantity');
        }
    }
    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
             $data = Cart::with(['product','product.images'])->where('user_id',$user_id)->where('order_id',null)->get();
            // print_r($data);
            
            return $data;
        }
        else{
            $data = Cart::with(['product','product.images'])->where('guest_id',request()->session()->get('guest_id'))->where('order_id',null)->get();
            // print_r($data);
            // die;
            return $data;
            // return 0;
        }
    }
    // Total amount cart
    public static function totalCartPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('amount');
        }
        else{
            return Cart::where('guest_id',request()->session()->get('guest_id'))->where('order_id',null)->sum('amount');
           // return 0;
        }
    }
    // Wishlist Count
    public static function wishlistCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        }
        else{
            return Wishlist::where('guest_id',request()->session()->get('guest_id'))->where('cart_id',null)->sum('quantity');

            //return 0;
        }
    }
    public static function getAllProductFromWishlist($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::with('product','product.images')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return Wishlist::with('product','product.images')->where('guest_id',request()->session()->get('guest_id'))->where('cart_id',null)->get();
            //return 0;
        }
    }
    public static function totalWishlistPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('amount');
        }
        else{
            return Wishlist::where('guest_id',request()->session()->get('guest_id'))->where('cart_id',null)->sum('amount');
          //  return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id,$user_id){
        $order=Order::find($id);
        dd($id);
        if($order){
            $shipping_price=(float)$order->shipping->price;
            $order_price=self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }

    public static function shipping(){
        return Shipping::orderBy('id','DESC')->where('type','Standard Shipping')->first();
    }

    

    public static function getModels(){
        $modelDirectory = app_path('Models');

            // Get all PHP files in the specified directory
            $files = File::allFiles($modelDirectory);

            // Initialize an array to store model names
            $modelNames = [];

            // Iterate through each file
            foreach ($files as $file) {
                // Get the class name from the file
                $className = pathinfo($file->getFilename(), PATHINFO_FILENAME);

                // Form the full namespace for the class
                $classNamespace = 'App\\Models\\' . $className;

                // Check if the class exists and is a subclass of Eloquent Model
                if (class_exists($classNamespace) && is_subclass_of($classNamespace, 'Illuminate\Database\Eloquent\Model')) {
                    // Add the model name to the array
                    $modelNames[] = $classNamespace;
                }
            }
        return $modelNames;
    }

    public static function generateRandomString($length = 4) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }




    
}

?>