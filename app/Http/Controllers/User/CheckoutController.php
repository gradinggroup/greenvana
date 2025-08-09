<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\Shipping;

use App\Models\province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PDF;

class CheckoutController extends Controller
{

    public function checkoutDetil(Request $request)
    {
        if (Session::has('coupon')) {
            $total_amount = Session::get('coupon')['total_amount'];
        } else {
            $total_amount = (int) str_replace(',', '', Cart::subtotal());
        }
        Log::info('Checkout request alamat:', [
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan_desa' => $request->kelurahan_desa,
        ]);
    
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $postCode = $request->post_code;
        $notes = $request->notes;
    
        // Ambil data lokasi (string) langsung dari request
        $provinsi = $request->provinsi;
        $kabupaten_kota = $request->kabupaten_kota;
        $kecamatan = $request->kecamatan;
        $kelurahan_desa = $request->kelurahan_desa;
    
        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'name'  => Auth::user()->name,
            'provinsi' => $provinsi,
            'kabupaten_kota' => $kabupaten_kota,
            'kecamatan' => $kecamatan,
            'kelurahan_desa' => $kelurahan_desa,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'post_code' => $postCode,
            'notes' => $notes,
            'payment_type' => $request->payment_type,
            'amount' => $total_amount,
            'transaction_id' => date('d-m-Y') . '-' . mt_rand(1000, 9999),
            'invoice_no' => 'MS' . mt_rand(10000000, 99999999),
            'confirmed_date' => Carbon::now(),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'Pending',
            'created_at' => Carbon::now(),
        ]);
    
        $carts = Cart::content();
        foreach ($carts as $cart) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart->id,
                'color' => $cart->options->color,
                'size' => $cart->options->size,
                'qty' => $cart->qty,
                'price' => $cart->price,
                'created_at' => Carbon::now(),
            ]);
        }
    
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => max(100, $total_amount), // minimal Rp 100 agar tidak error Midtrans
            ],
            'customer_details' => [
                'first_name' => $name,
                'email' => $email,
                'phone' => $phone,
            ],
        ];
    
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
    
        Cart::destroy();
    
        return view('frontend.checkout.detil_checkout', compact(
            'carts',
            'name',
            'email',
            'phone',
            'provinsi',
            'kabupaten_kota',
            'kecamatan',
            'kelurahan_desa',
            'postCode',
            'notes',
            'total_amount',
            'snapToken',
            'order_id'
        ));
    }
    


    public function checkoutStore(Request $request)
    {
        $id_order = $request->id_order;
        $data = json_decode($request->get('json'));
        Order::findOrFail($id_order)->update([
            'status' => 'Success',
            'payment_type' => $data->payment_type,
            'transaction_id' => $data->transaction_id,
        ]);

        $notification = array(
            'message' => 'Pembayaran Success',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard')->with($notification);
    }


    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('id','DESC')->get();
        return view('frontend.user.order.view_order', compact('orders'));
    }

    public function orderDetil($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
    
        $orderItem = OrderItem::with('product')
            ->where('order_id', $id)
            ->orderBy('id', 'DESC')
            ->get();
                // cek dulu isi $order sebelum dikirim
    Log::info('Order data:', $order ? $order->toArray() : ['order' => 'null']);
    
        return view('frontend.user.order.order_detil', compact('order', 'orderItem'));
    }
    

    public function downloadInvoice($id)
    {
        $order = Order::with('province','regency','district','village')->where('id', $id)->where('user_id',Auth::id())->first();
        $orderItem = OrderItem::with('product')->where('order_id',$id)->orderBy('id', 'DESC')->get();


        // return view('frontend.user.invoice.view_invoice',compact('order','orderItem'));

        $pdf = Pdf::loadView('frontend.user.invoice.view_invoice', compact('order','orderItem'))->setPaper('a4')->setOptions([
                'tempDir' => public_path(),
                'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    }


}
