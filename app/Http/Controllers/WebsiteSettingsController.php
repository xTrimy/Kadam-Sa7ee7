<?php

namespace App\Http\Controllers;

use App\Models\Website\InsightsBar;
use App\Models\Website\SliderImage;
use Illuminate\Http\Request;

class WebsiteSettingsController extends Controller
{
    public function slider_images()
    {
        $slider_images = SliderImage::all();
        return view('settings.website.slider_images',compact('slider_images'));
    }

    public function slider_images_store(Request $request)
    {
        foreach($request->id as $key => $id){
            if($id){
                $slider_image = SliderImage::find($id);
            }else{
                $slider_image = new SliderImage();
            }
            // slider image upload
            if($request->title[$key] == null){
                $slider_image->delete();
                continue;
            }
            if(isset($request->image) && isset($request->image[$key])){
                $image = $request->file('image')[$key];
                $image_name = time() . $image->getClientOriginalName();
                $image->move(public_path('uploads/slider_images'), $image_name);
                $slider_image->image = $image_name;
            }else if($slider_image->id == null){
                continue;
            }
            $slider_image->title = $request->title[$key];
            $slider_image->description = $request->description[$key];
            $slider_image->save();
        }
        return back()->with('success',__('Slider Images Updated Successfully'));
    }

    public function insights_bar(){
        // read file from public folder
        $file = file_get_contents(public_path('font-awesome.json'));
        $icons = json_decode($file);
        $insights_bar = InsightsBar::all();
        return view('settings.website.insight_bars',compact('insights_bar','icons'));
    }

    public function insights_bar_store(Request $request)
    {
        foreach($request->id as $key => $id){
            if($id){
                $insights_bar = InsightsBar::find($id);
            }else{
                $insights_bar = new InsightsBar();
            }
            if($request->title[$key] == null){
                $insights_bar->delete();
                continue;
            }
            $insights_bar->title = $request->title[$key];
            $insights_bar->description = $request->number[$key];
            $insights_bar->icon = $request->icon[$key];
            $insights_bar->save();
        }
        return back()->with('success',__('Insights Bar Updated Successfully'));
    }
}
