<?php

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

if (!function_exists('getInventory')) {
    function getInventory($item_wps_id)
    {
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


