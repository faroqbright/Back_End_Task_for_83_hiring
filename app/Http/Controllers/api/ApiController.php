<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AdvertisingCompaign;
use App\Models\Image;
use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function compaignList()
    {
        try{
            return $compaigns = AdvertisingCompaign::with(['images' => function ($q){
                $q->select('id','file','advertising_compaign_id');
            }])->get();
            if($compaigns){
                return response()->json(['status' => 200, 'compaigns' => $compaigns]);
            }else{
                return response()->json(['status' => 204, 'message' => 'No compaign found']);
            }
        } catch(Exception $exc){
            return response()->json(["message" => $exc->getMessage()]);
        }
    }

    public function add_compaign(Request $request)
    {
        try{
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
            $compaigns = $add_compaign->save();
            if($compaigns){
                return response()->json(['status' => 200, 'message' => 'Compaign added successfully']);
            }else{
                return response()->json(['status' => 204, 'message' => 'Something went wrong']);
            }
        } catch(Exception $exc){
            return response()->json(["message" => $exc->getMessage()]);
        }
    }
    public function edit_compaign(Request $request)
    {
       try{
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
                        unlink($image_path);
                        $related_images->delete();
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
        if($compaign){
            return response()->json(['status' => 200, 'message' => 'Compaign edited successfully']);
        }else{
            return response()->json(['status' => 204, 'message' => 'Something went wrong']);
        }
        }catch(Exception $exc){
            return response()->json(["message" => $exc->getMessage()]);
        }
    }
    public function delete_compaign($id)
    {
        try{
            $compaign = AdvertisingCompaign::where('id', $id)->first();
            $compaign->delete();
            if($compaign){
                return response()->json(['status' => 200, 'message' => 'Compaign Deleted successfully']);
            }else{
                return response()->json(['status' => 204, 'message' => 'Something went wrong']);
            }
            }catch(Exception $exc){
                return response()->json(["message" => $exc->getMessage()]);
        }
    }
}
