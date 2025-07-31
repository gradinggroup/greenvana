<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Slider;

use Carbon\Carbon;
use Image;

class SliderController extends Controller
{
    
    public function viewSlider()
    {
        $sliders = Slider::latest()->get();
        return view('admin.sliders.view_slider', compact('sliders'));
    }

    public function sliderStore(Request $request)
    {
        $request->validate([
            'slider_img' => 'required',
        ],[
            'slider_img.required' => 'Pleaseeeee... Slider harus diisi!'
        ]);

        $image = $request->file('slider_img');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(870,370)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'slider_img' => $save_url,
        ]);

        $notification = array(
            'message' => 'Slider Berhasil Di Tambahkan!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function sliderEdit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit_slider', compact('slider'));
    }

    public function sliderUpdate(Request $request, $id)
    {
       $old_img = $request->old_image;

       if($request->file('slider_img')){

            unlink($old_img);
            $image = $request->file('slider_img');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(870,370)->save('upload/slider/'.$name_gen);
            $save_url = 'upload/slider/'.$name_gen;

            Slider::findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'slider_img' => $save_url,
            ]);

            $notification = array(
            'message' => 'Slider Berhasil Di Update!',
            'alert-type' => 'success',
        );

        return redirect()->route('manage.slider')->with($notification);

       }else{

                Slider::findOrFail($id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                ]);

                $notification = array(
                'message' => 'Slider Berhasil Di Update!',
                'alert-type' => 'success',
            );

            return redirect()->route('manage.slider')->with($notification);
        }
    }

    public function sliderActive($id)
    {
        Slider::findOrFail($id)->update([
            'status' => 1,
        ]);

        $notification = array(
            'message' => 'Slider Actived!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function sliderInActive($id)
    {
        Slider::findOrFail($id)->update([
            'status' => 0,
        ]);

        $notification = array(
            'message' => 'Slider InActived!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function sliderDelete($id)
    {
        $slider = Slider::findOrFail($id);
        $img = $slider->slider_img;
        unlink($img);
        Slider::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Slider Berhasil diHapus!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);

    }





}
