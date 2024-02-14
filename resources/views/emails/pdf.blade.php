<!DOCTYPE html>
<html style="box-sizing: border-box;font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;-webkit-tap-highlight-color: transparent;">
<head style="box-sizing: border-box;">
  <title style="box-sizing: border-box;">Order @if($order)- {{$order->order_number}} @endif</title>
  
</head>
<body style="box-sizing: border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #fff;min-width: 992px!important;">

@if($order)

  <div class="invoice-header" style="width:100%; float:left;box-sizing: border-box;background: #f7f7f7;padding: 10px 20px 10px 20px;border-bottom: 1px solid gray;">
    @php
    $settings=DB::table('settings')->get();
    
@endphp
    <div class="float-left site-logo" style="box-sizing: border-box;margin-top: 20px;float: left!important;">
     
      <img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" alt="" style="box-sizing: border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;width: 200px;">
    </div>
    <div class="float-right site-address" style="box-sizing: border-box;float: right!important;">
      <h4 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1.5rem;">{{env('APP_NAME','DMC Motorsports')}}</h4>
      <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;line-height: 6px;font-weight: 300;">@foreach($settings as $data) {{$data->address}} @endforeach</p>
      <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;line-height: 6px;font-weight: 300;">Phone: <a href="tel:{{env('APP_PHONE')}}" style="box-sizing: border-box;color: #007bff;text-decoration: underline;background-color: transparent;">@foreach($settings as $data) {{$data->phone}} @endforeach</a></p>
      <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;line-height: 6px;font-weight: 300;">Email: <a href="mailto:{{env('APP_EMAIL')}}" style="box-sizing: border-box;color: #007bff;text-decoration: underline;background-color: transparent;">@foreach($settings as $data) {{$data->email}} @endforeach</a></p>
    </div>
    <div class="clearfix" style="box-sizing: border-box;"></div>
  </div>
  <div class="invoice-description" style="box-sizing: border-box;">
    <div class="invoice-left-top float-left" style="box-sizing: border-box;border-left: 4px solid green;padding-left: 20px;padding-top: 20px;float: left!important;">
      <h6 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1rem;">Invoice to</h6>
       <h3 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1.75rem;orphans: 3;widows: 3;page-break-after: avoid;">{{$order->first_name}} {{$order->last_name}}</h3>
       <div class="address" style="box-sizing: border-box;">
        <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 3px;orphans: 3;widows: 3;margin: 0;line-height: 20px;font-size: 16px;">
          <strong style="box-sizing: border-box;font-weight: bolder;">Country: </strong>
          {{$order->country}}
        </p>
        <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 3px;orphans: 3;widows: 3;margin: 0;line-height: 20px;font-size: 16px;">
          <strong style="box-sizing: border-box;font-weight: bolder;">Address: </strong>
          {{ $order->address1 }} OR {{ $order->address2}}
        </p>
         <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 3px;orphans: 3;widows: 3;margin: 0;line-height: 20px;font-size: 16px;"><strong style="box-sizing: border-box;font-weight: bolder;">Phone:</strong> {{ $order->phone }}</p>
         <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 3px;orphans: 3;widows: 3;margin: 0;line-height: 20px;font-size: 16px;"><strong style="box-sizing: border-box;font-weight: bolder;">Email:</strong> {{ $order->email }}</p>
       </div>
    </div>
    <div class="text-right" style="box-sizing: border-box;text-align: right!important;">
      <h3 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1.75rem;orphans: 3;widows: 3;page-break-after: avoid;">Invoice #{{$order->order_number}}</h3>
      <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;">{{ $order->created_at->format('D d m Y') }}</p>
      {{-- <img class="img-responsive" src="data:image/png;base64, {{ base64_encode(QrCode::format('png')-&gt;size(150)-&gt;generate(route('admin.product.order.show', $order-&gt;id )))}}" style="box-sizing: border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;"> --}}
    </div>
    <div class="clearfix" style="box-sizing: border-box;"></div>
  </div>
  <section class="order_details pt-3" style="width: 100%;float: left;box-sizing: border-box;display: block;padding-top: 1rem!important;">
    <div class="table-header" style="box-sizing: border-box;padding: .75rem 1.25rem;margin-bottom: 0;background-color: rgba(0,0,0,.03);border-bottom: 1px solid rgba(0,0,0,.125);">
      <h5 style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1.25rem;">Order Details</h5>
    </div>
    <table class="table table-bordered table-stripe" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;border: none;">
      <thead style="box-sizing: border-box;display: table-header-group;background: green;color: #FFF;">
        <tr style="box-sizing: border-box;page-break-inside: avoid;">
          <th scope="col" class="col-6" style="color:#000; box-sizing: border-box;text-align: inherit;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;padding: .30rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important;">Product</th>
          <th scope="col" class="col-3" style="color:#000; box-sizing: border-box;text-align: inherit;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;padding: .30rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important;">Quantity</th>
          <th scope="col" class="col-3" style="color:#000; box-sizing: border-box;text-align: inherit;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 25%;flex: 0 0 25%;max-width: 25%;padding: .30rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;border-bottom-width: 2px;background-color: #fff!important;border: 1px solid #dee2e6!important;">Total</th>
        </tr>
      </thead>
      <tbody style="box-sizing: border-box;">
      @foreach($order->cart_info as $cart)
      @php 
        $product=DB::table('items')->select('name')->where('id',$cart->product_id)->get();
   
      @endphp
        <tr style="box-sizing: border-box;page-break-inside: avoid;">
          <td style="box-sizing: border-box;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">
          <span style="box-sizing: border-box; width:100%; float:left;">
          {{$cart->product->name}} 
            </span>
            <span style="box-sizing: border-box; width:100%; float:left;">SKU: {{@$cart->product->sku}}</span>
          </td>
          <td style="box-sizing: border-box;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">x{{$cart->quantity}}</td>
          <td style="box-sizing: border-box;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;"><span style="box-sizing: border-box;">${{number_format($cart->price,2)}}</span></td>
        </tr>
      @endforeach
      </tbody>
      <tfoot style="box-sizing: border-box;">
        <tr style="box-sizing: border-box;page-break-inside: avoid;">
          <th scope="col" class="empty" style="box-sizing: border-box;text-align: inherit;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;border: 1px solid #dee2e6!important;background-color: #fff!important;"></th>
          <th scope="col" class="text-right" style="box-sizing: border-box;text-align: right!important;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">Subtotal:</th>
          <th scope="col" style="box-sizing: border-box;text-align: inherit;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;"> <span style="box-sizing: border-box;">${{number_format($order->sub_total,2)}}</span></th>
        </tr>
   
        <tr style="box-sizing: border-box;page-break-inside: avoid;">
          <th scope="col" class="empty" style="box-sizing: border-box;text-align: inherit;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;border: 1px solid #dee2e6!important;background-color: #fff!important;"></th>
          @php
            $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
          @endphp
          <th scope="col" class="text-right " style="box-sizing: border-box;text-align: right!important;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">Shipping:</th>
          <th style="box-sizing: border-box;text-align: inherit;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;"><span style="box-sizing: border-box;">${{number_format($shipping_charge[0],2)}}</span></th>
        </tr>
        <tr style="box-sizing: border-box;page-break-inside: avoid;">
          <th scope="col" class="empty" style="box-sizing: border-box;text-align: inherit;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;border: 1px solid #dee2e6!important;background-color: #fff!important;"></th>
          <th scope="col" class="text-right" style="box-sizing: border-box;text-align: right!important;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">Total:</th>
          <th style="box-sizing: border-box;text-align: inherit;padding: .30rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;border: 1px solid #dee2e6!important;">
            <span style="box-sizing: border-box;">
                ${{number_format($order->total_amount,2)}}
            </span>
          </th>
        </tr>
      </tfoot>
    </table>
  </section>
  <div class="thanks mt-3" style="width: 100%;float: left;box-sizing: border-box;margin-top: 1rem!important;">
    <h4 style="box-sizing: border-box;margin-top: 20px;margin-bottom: .5rem;font-weight: normal;line-height: 1.2;font-size: 25px;color: green;font-family: serif;">Thanks for Purchase with us !!</h4>
  </div>
  <div class="authority float-right mt-5" style="box-sizing: border-box;float: right!important;margin-top: 3rem!important;">
    <img src="https://dmc-motorsports.com/public/storage/photos/1/Logo/dmc-logo.png" alt="" width="200" style="box-sizing: border-box;vertical-align: middle;border-style: none;page-break-inside: avoid;">
    <p style="box-sizing: border-box;margin-top: 0;margin-bottom: 1rem;orphans: 3;widows: 3;">-----------------------------------</p>
    <h5 style="box-sizing: border-box;margin-top: -10px;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1.25rem;color: green;">Authority Signature:</h5>
  </div>
  <div class="clearfix" style="box-sizing: border-box;"></div>
@else
  <h5 class="text-danger" style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 1.25rem;color: #dc3545!important;">Invalid</h5>
@endif
</body>
</html>