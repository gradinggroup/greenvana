<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Products;
use App\Models\MultiImg;
use App\Models\Brand;
use Auth;

use Illuminate\Support\Facades\Hash;


class IndexController extends Controller
{

    public function index()
    {
        $sliders = Slider::where('status',1)->limit(3)->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $products = Products::where('status',1)->orderBy('id','DESC')->limit(6)->get();
        $featured = Products::where('featured',1)->orderBy('id','DESC')->limit(6)->get();
        $hotDeals = Products::where('hot_deals',1)->orderBy('id','DESC')->limit(3)->get();
        $specialOffer = Products::where('special_offer',1)->orderBy('id','DESC')->limit(3)->get();
        $specialDeals = Products::where('special_deals',1)->orderBy('id','DESC')->limit(3)->get();

        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Products::where('status',1)->where('category_id',$skip_category_0->id)->orderBy('id','DESC')->get();

        $skip_category_1 = Category::skip(1)->first();
        $skip_product_1 = Products::where('status',1)->where('category_id',$skip_category_1->id)->orderBy('id','DESC')->get();

        $skip_brand_5 = Brand::skip(0)->first();
        $skip_product_5 = Products::where('status',1)->where('brand_id',$skip_brand_5->id)->orderBy('id','DESC')->get();


        return view('frontend.index', compact('categories','sliders','products','featured','hotDeals','specialOffer','specialDeals','skip_product_0','skip_product_1','skip_product_5'));
    }

    public function detail($id,$slug)
    {
        $product = Products::findOrFail($id);

        $color_en = $product->product_color_en;
        $product_color_en = explode(',', $color_en);

        $color_ind = $product->product_color_ind;
        $product_color_ind = explode(',', $color_ind);

        $size_en = $product->product_size_en;
        $product_size_en = explode(',', $size_en);

        $size_ind = $product->product_size_ind;
        $product_size_ind = explode(',', $size_ind);

        $multiImg = MultiImg::where('product_id',$id)->get();
        $hotDeals = Products::where('hot_deals',1)->orderBy('id','DESC')->limit(3)->get();

        $relatedProduct = Products::where('category_id',$product->category_id)->where('id','!=',$id)->orderBy('id','DESC')->get();
        return view('frontend.product.detail_product',compact('product','multiImg','product_color_en','product_color_ind','product_size_en','product_size_ind','relatedProduct','hotDeals'));
    }

    public function userLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function userProfileEdit()
    {
       $id = Auth::user()->id;
       $user = User::find($id);

       return view('frontend.profile.user_profile',compact('user'));
    }

    public function userProfileUpdate(Request $request)
    {
        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if($request->file('profile_photo_path')){
            $file = $request->file('profile_photo_path');
            @unlink(public_path('upload/user_images/'.$data->profile_photo_path));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }

        $data->save();


        $notification = array(
            'message' => 'Data User Berhasil Diupdate!',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard')->with($notification);
    }

    public function changePassword()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.change_password', compact('user'));
    }

    public function userUpdatePassword(Request $request)
    {
        $validation = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hasPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword,$hasPassword)){
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('user.logout');
        }else{
            return redirect()->back();
        }
    }

    public function tagProduct($tag)
    {
        $products = Products::where('status',1)->where('product_tags_en',$tag)->where('product_tags_ind',$tag)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();

        return view('frontend.tags.tags_view',compact('products','categories'));
    }

    public function subcatProduct($subcat_id, $slug)
    {
        $products = Products::where('status',1)->where('subcategory_id',$subcat_id)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();

        return view('frontend.category.product_category',compact('products','categories'));
    }

    public function subsubcatProduct($subsubcat_id, $slug)
    {
        $products = Products::where('status',1)->where('subsubcategory_id',$subsubcat_id)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();

        return view('frontend.category.subsubcategory_product',compact('products','categories'));
    }


    //get data product by ajax
    public function getProductModal($id)
    {
        $product = Products::with('category','brand')->findOrFail($id);

        $color = $product->product_color_en;
        $product_color = explode(',', $color);

        $size = $product->product_size_en;
        $product_size = explode(',', $size);

        return response()->json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size
        ));
    }







}
