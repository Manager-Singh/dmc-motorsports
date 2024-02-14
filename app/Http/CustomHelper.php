<?php
use App\Models\Attributekey;
use App\Models\Attributevalue;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
if (!function_exists('assets')) {
    function assets($path, $secure = null)
    {
        // Your custom implementation here
        // You can call the original asset function if needed
        // return \Illuminate\Support\Facades\URL::asset($path, $secure);

        // Or implement your own logic
        return 'public/' . $path;
    }
}

if (!function_exists('getAttributeKeyName')) {
    function getAttributeKeyName($attributekey_id)
    {

        return Attributekey::where('wps_id',$attributekey_id)->first()->name;
        
    }
}
if (!function_exists('genrateWpsId')) {
    function genrateWpsId()
    {
        // Retrieve the latest wps_id from the 'Item' model or use 0 if no records are present
        $latestItem = Item::orderBy('wps_id', 'DESC')->first();
        $wps_id = $latestItem ? $latestItem->wps_id : 0;
    
        // Define a salt value (e.g., using a named constant)
        $salt =  99;
        $timestamp = microtime(true) * 10000;
        // Generate a random integer between 10000 and 99999
        $pre = random_int(1111, 9999);
    
        // Generate another random integer between 100000 and 9999999
        $post = random_int(1111, 9999);
    
        // Calculate the sum of the random integers and the retrieved wps_id
        $sum = $pre +$post+$timestamp;
       // $counter = mt_rand();
    
        // Concatenate the salt and sum to create the final UUID
        $uuid = $salt .$sum;
    
        // Return the generated UUID
        return $uuid;
    }
}
if (!function_exists('getInventory')) {
    function getInventory($item_wps_id)
    {
        
        $item = Item::with('inventory')->where('wps_id',$item_wps_id)->first();
       // print_r( $item->inventory);
        // die;
        if($item->type == 'custom'){
            
            if(isset($item->inventory)){
                return $item->inventory->total;
            }
            return 0;
        }else{
    $curl = curl_init();

    try {
    // Set cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.wps-inc.com/inventory?filter[item_id]=".$item_wps_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer zNsW6dBeTgHS4qk0AEnbO86ibp5jrmPUYUJDNagE",
            "User-Agent: insomnia/8.4.5"
        ],
    ]);

    // Execute cURL request
    $response = curl_exec($curl);

    // Check for cURL errors
    if ($response === false) {
        throw new Exception("cURL Error: " . curl_error($curl));
    }

    // Your code to process the $response goes here...

    // Close cURL session
    curl_close($curl);

    // Output the response
    $response = json_decode($response);
    if(count($response->data)>0){
        return $response->data[0]->total;
    }
    return 0;
} catch (Exception $e) {
    // Handle exceptions
    echo "Error: " . $e->getMessage();
} finally {
    // Close cURL session in case of an exception
    if ($curl) {
        curl_close($curl);
    }
}
    }
}
}




