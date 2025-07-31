<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Products;
use App\Models\Brand;
use App\Models\MultiImg;

use Carbon\Carbon;
use Image;

class ProductController extends Controller
{
    public function addProduct()
    {
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $brands = Brand::latest()->get();
        return view('admin.product.product_add',compact('categories','subcategories','brands'));
    }

    public function storeProduct(Request $request)
    {

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(917,1000)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;

        $product_id = Products::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_code' => $request->product_code,
            'product_name_en' => $request->product_name_en,
            'product_name_ind' => $request->product_name_ind, 
            'product_slug_en' => strtolower(str_replace(' ', '-', $request->product_name_en,)),
            'product_slug_ind' => strtolower(str_replace(' ', '-', $request->product_name_ind,)),
            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_ind' => $request->product_tags_ind,
            'product_size_en' => $request->product_size_en,
            'product_size_ind' => $request->product_size_ind,
            'product_color_en' => $request->product_color_en,
            'product_color_ind' => $request->product_color_ind,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_ind' => $request->short_descp_ind,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_ind' => $request->long_descp_ind,
            'product_thambnail' => $save_url,
            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        //insert data multiple image
        $images = $request->file('multiple_img');
        foreach ($images as $img) {
            $make_img = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(917,1000)->save('upload/products/product_img/'.$make_img);
            $save_img = 'upload/products/product_img/'.$make_img;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $save_img,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Product Berhasil Di Tambahkan!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);


    }

    public function manageProduct()
    {
        $products = Products::latest()->get();
        return view('admin.product.product_view',compact('products'));
    }

    public function editProduct($id)
    {
        $multipleImg = MultiImg::where('product_id',$id)->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $subsubcategories = SubSubCategory::latest()->get();
        $products = Products::findOrFail($id);

        return view('admin.product.product_edit',compact('brands','categories','subcategories','subsubcategories','products','multipleImg'));
    }

    public function updateDataProduct(Request $request, $id)
    {
        Products::findOrFail($id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_code' => $request->product_code,
            'product_name_en' => $request->product_name_en,
            'product_name_ind' => $request->product_name_ind, 
            'product_slug_en' => strtolower(str_replace(' ', '-', $request->product_name_en,)),
            'product_slug_ind' => strtolower(str_replace(' ', '-', $request->product_name_ind,)),
            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_ind' => $request->product_tags_ind,
            'product_size_en' => $request->product_size_en,
            'product_size_ind' => $request->product_size_ind,
            'product_color_en' => $request->product_color_en,
            'product_color_ind' => $request->product_color_ind,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_ind' => $request->short_descp_ind,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_ind' => $request->long_descp_ind,
            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => 1,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Product Berhasil Di Update!',
            'alert-type' => 'success',
        );

        return redirect()->route('manage-product')->with($notification);

    }

    //update multiple image
    public function updateDataImages(Request $request)
    {
        $imgs = $request->multiple_img;


        foreach($imgs as $id => $img){

            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_img = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(917,1000)->save('upload/products/product_img/'.$make_img);
            $update_images = 'upload/products/product_img/'.$make_img;

            MultiImg::where('id',$id)->update([
                'photo_name' => $update_images,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Product Images Berhasil Di Update!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }
    //end method multiple image

    public function updateThambnail(Request $request, $id)
    {
        $oldImg = $request->old_image;
        unlink($oldImg);

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(917,1000)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;

        Products::findOrFail($id)->update([
                'product_thambnail' => $save_url,
                'updated_at' => Carbon::now(),
            ]);
        $notification = array(
            'message' => 'Product Thambnail Berhasil Di Update!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);

    }

    public function imgsDelete($id)
    {
        $imgs = MultiImg::findOrFail($id);
        unlink($imgs->photo_name);
        MultiImg::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Multiple Image Berhasil Di delete!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function productActive($id)
    {
        Products::findOrFail($id)->update([
            'status' => 1,
        ]);

        $notification = array(
            'message' => 'Product Actived!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function productInActive($id)
    {
        Products::findOrFail($id)->update([
            'status' => 0,
        ]);

        $notification = array(
            'message' => 'Product InActived!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function productDelete($id)
    {
        $product = Products::findOrFail($id);
        unlink($product->product_thambnail);
        Products::findOrFail($id)->delete();

        $images = MultiImg::where('product_id',$id)->get();
        foreach($images  as $img){
            unlink($img->photo_name);
            MultiImg::where('product_id',$id)->delete();
        }

        $notification = array(
            'message' => 'Product berhasil dihapus!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }






}
