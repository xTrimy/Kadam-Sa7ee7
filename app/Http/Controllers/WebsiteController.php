<?php

namespace App\Http\Controllers;

use App\Models\Website\InsightsBar;
use App\Models\Website\SliderImage;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $slider_images = SliderImage::all();
        $insights_items = InsightsBar::all(); 
        return view('website.home',compact('slider_images','insights_items'));
    }
}
