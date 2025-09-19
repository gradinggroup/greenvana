<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Wishlist;
use App\Models\Coupon;
use App\Models\Province;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {

        if(Session::has('coupon')){
            Session::forget('coupon');
        }

        $product = Products::findOrFail($id);

        if($product->discount_price == NULL){
            Cart::add([
                'id' => $id, 
                'name' => $request->product_name, 
                'qty' => $request->qty, 
                'price' => $product->selling_price, 
                'weight' => 1, 
                'options' => [
                    'size' => $request->size,
                    'color' => $request->color,
                    'image' => $product->product_thambnail,
                ],
            ]);

            return response()->json(['success' => 'Data Berhasil ditambhkan ke Kerjanjang']);
        }else{

            Cart::add([
                'id' => $id, 
                'name' => $request->product_name, 
                'qty' => $request->qty, 
                'price' => $product->discount_price, 
                'weight' => 1, 
                'options' => [
                    'size' => $request->size,
                    'color' => $request->color,
                    'image' => $product->product_thambnail,
                ],
            ]);

            return response()->json(['success' => 'Data Berhasil ditambhkan ke Keranjang']);

        }
    }

    public function addMiniCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal,
        ));
    }

    public function removeMiniCart($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'Data Keranjang Berhasil Dihapus!']);
    }


    public function addToWishlist(Request $request, $product_id)
    {
        if(Auth::check()){

            $exists = Wishlist::where('user_id',Auth::id())->where('product_id',$product_id)->first();

            if(!$exists){
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'product_id' => $product_id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json(['success' => 'Product Berhasil Disimpan diWishlist']);
            }else{
                return response()->json(['error' => 'Product Sudah Ada Di Wishlist!']);
            }

            

        }else{
            return response()->json(['error' => 'Silahkan Login Terlebih Dulu!']);
        }
    }

    public function couponApply(Request $request)
    {
        $coupon = Coupon::where('coupon_name',$request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first();

        if($coupon){

            $total = (int)str_replace(',','', Cart::subtotal());

            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => $total * $coupon->coupon_discount/100,
                'total_amount' => $total - $total * $coupon->coupon_discount/100
            ]);

            return response()->json(array(
                'success' => 'Kupon Berhasil Digunakan'
            ));

        }else{
            return response()->json(['error' => 'Kupon Tidak Berlaku!']);
        }
    }

    public function couponCalculation()
    {
        if(Session::has('coupon')){
            return response()->json(array(
                'subtotal' => Cart::subtotal(),
                'coupon_name' => session()->get('coupon')['coupon_name'],
                'coupon_discount' => session()->get('coupon')['coupon_discount'],
                'discount_amount' => session()->get('coupon')['discount_amount'],
                'total_amount' => session()->get('coupon')['total_amount'],
            ));
        }else{
            return response()->json(array(
                'total' => Cart::subtotal(),
            ));
        }
    }

    public function couponRemove()
    {
        Session::forget('coupon');
        return response()->json(['success' => 'Kupon Berhsail Dihapus!']);
    }


    public function checkoutCreate()
    {
        if(Auth::check()){

            if(Cart::total() > 0){

                $user = Auth::user();
                $carts = Cart::content();
                $cartQty = Cart::count();
                $total = Cart::subtotal();
                $store = \App\Models\StoreAddress::first(); // ambil alamat toko
                $provinces = Province::all();
                $total = (int) preg_replace('/\D/', '', $total);
                $vouchers = \App\Models\Voucher::where('user_id', Auth::id())
                ->where('status', 'aktif')
                ->get();
                $poin_user = DB::table('poin_users')->where('user_id', $user->id)->value('total_poin') ?? 0;


                return view('frontend.checkout.checkout_view', compact('carts','store', 'cartQty', 'total','provinces','vouchers','poin_user')); 

            }else{

                $notification = array(
                    'message' => 'Tidak Ada Data Produk!',
                    'alert-type' => 'error',
                );

                return redirect()->to('/')->with($notification);
            }

        }else{

            $notification = array(
                'message' => 'Silahkan Login Terlebih Dulu!',
                'alert-type' => 'error'
            );

            return redirect()->route('login')->with($notification);
        }


    }





}
