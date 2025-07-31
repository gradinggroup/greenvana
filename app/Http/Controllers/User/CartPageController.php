<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;

class CartPageController extends Controller
{
    public function myCart()
    {
        return view('frontend.mycart.view_mycart');
    }

    public function getMyCart()
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

    public function removeMyCart($rowId)
    {
        Cart::remove($rowId);

        if(Session::has('coupon')){
            Session::forget('coupon');
        }

        return response()->json(['success' => 'Data Cart Berhasil Dihapus!']);
    }

    public function incrementMyCart($rowId)
    {
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty + 1);

        if(Session::has('coupon')){

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

             $total = (int)str_replace(',','', Cart::subtotal());

            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => $total * $coupon->coupon_discount/100,
                'total_amount' => $total - $total * $coupon->coupon_discount/100
            ]);
        }

        return response()->json('increment');
    }

    public function decrementMyCart($rowId)
    {
        $row = Cart::get($rowId);
        Cart::update($rowId, $row->qty - 1);

        if(Session::has('coupon')){

            $coupon_name = Session::get('coupon')['coupon_name'];
            $coupon = Coupon::where('coupon_name',$coupon_name)->first();

             $total = (int)str_replace(',','', Cart::subtotal());

            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => $total * $coupon->coupon_discount/100,
                'total_amount' => $total - $total * $coupon->coupon_discount/100
            ]);
        }

        return response()->json('decrement');
    }


}
