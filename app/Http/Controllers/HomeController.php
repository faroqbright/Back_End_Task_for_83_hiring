<?php

namespace App\Http\Controllers;

use App\Models\AdvertisingCompaign;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $compaigns = AdvertisingCompaign::with('images')->get();
        return view('home', ['compaigns' => $compaigns]);
    }
    public function add_compaign_page()
    {
        return view('add_compaign_page');
    }
    public function add_compaign(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'daily_budget'=> 'required',
            'total'=> 'required',
            'images'=> 'required',
        ]);
        $add_compaign = new AdvertisingCompaign();
        $add_compaign->name = $request->name;
        $add_compaign->start_date = $request->start_date;
        $add_compaign->end_date = $request->end_date;
        $add_compaign->daily_budget = $request->daily_budget;
        $add_compaign->total = $request->total;
        $add_compaign->save();
        if($request->images){
            foreach ($request->images as $key => $item) {
                $name = $item->getClientOriginalName();
                $filename = time().'.' . $name;
                $item->move(public_path('compaign-images'), $filename);
                $images = new Image();
                $images->advertising_compaign_id = $add_compaign->id;
                $images->file = $filename;
                $images->save();
            }
        }
        $add_compaign->save();
        return back();
    }
    public function compaign_edit_page($id){
        $compaign = AdvertisingCompaign::where('id', $id)->first();
        return view('compaign_edit_page', ['compaign' => $compaign]);
    }
    public function edit_compaign(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'daily_budget'=> 'required',
            'total'=> 'required',
        ]);
        $compaign = AdvertisingCompaign::where('id', $request->id)->first();
        $compaign->name = $request->name;
        $compaign->start_date = $request->start_date;
        $compaign->end_date = $request->end_date;
        $compaign->daily_budget = $request->daily_budget;
        $compaign->total = $request->total;
        if($request->images){
            $related_images = Image::where('advertising_compaign_id', $request->id)->get();
            if(count($related_images) > 0){
                foreach ($related_images as $key => $item) {
                    $image_path = public_path("compaign-images/" . $item->file);
                    if ($image_path) {
                        //File::delete($image_path);
                        $related_images->delete();
                        unlink($image_path);
                    }
                }
            }
            foreach ($request->images as $key => $item) {
                $name = $item->getClientOriginalName();
                $filename = time().'.' . $name;
                $item->move(public_path('compaign-images'), $filename);
                $images = new Image();
                $images->advertising_compaign_id = $compaign->id;
                $images->file = $filename;
                $images->save();
            }
        }
        $compaign->save();
        return back();
    }
    public function delete_compaign($id)
    {
        $compaign = AdvertisingCompaign::where('id', $id)->first();
        $compaign->delete();
        return redirect('home');
    }
}
