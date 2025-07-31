<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

use Carbon\Carbon;

class CouponController extends Controller
{
    
    public function viewCoupon()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupon.view_coupon', compact('coupons'));
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'coupon_name' => 'required',
            'coupon_discount' => 'required',
            'coupon_validity' => 'required',
        ],[
            'coupon_name.required' => 'Nama Kupon Wajib Diisi!',
            'coupon_discount.required' => 'Diskon Kupon Wajib Diisi!'
        ]);

        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Kupon Berhasil Di Tambahkan!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function editCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit_coupon', compact('coupon'));
    }

    public function updateCoupon(Request $request, $id)
    {
        Coupon::findOrFail($id)->update([
            'coupon_name' => $request->coupon_name,
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Kupon Berhasil Di Update!',
            'alert-type' => 'success',
        );

        return redirect()->route('manage.coupon')->with($notification);
    }

    public function deleteCoupon($id)
    {
        Coupon::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Kupon Berhasil Di Hapus!',
            'alert-type' => 'success',
        );

        return redirect()->route('manage.coupon')->with($notification);
    }




}
