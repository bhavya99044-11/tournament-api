<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelAmenities;
use App\Models\Room;
use Illuminate\Support\Facades\Log;
class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $hotel=Hotel::all();
            return response()->json([
               'success'=>true,
               'status'=>200,
               'message'=>'Hotels fetched successfully',
               'data'=>$hotel
            ]);
            }catch(\Exception $e){
                return response()->json([
                   'success'=>false,
                   'staus'=>404,
                   'message'=>'Failed to fetch hotel details',
                ]);
            }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $path=public_path('images');
            $fileName=time().$request->file('hotel_image')->getClientOriginalName();
            $request->file('hotel_image')->move($path,$fileName);
            $hotel=Hotel::create([
                'name'=>$request->hotel,
                'image_url'=>$fileName,
            ]);
            foreach($request->amenities as $amenitie){
                Log::info($amenitie);
                HotelAmenities::create([
                    'name'=>$amenitie,
                    'hotel_id'=>$hotel->id
                ]);
            }
            return response()->json([
               'success'=>true,
               'status'=>200,
               'message'=>'Hotel created successfully',
               'data'=>$hotel
            ]);
        }catch(\Exception $e){
            return response()->json([
               'success'=>false,
               'staus'=>404,
               'message'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Int $id)
    {
        try{
                $hotel=Hotel::with(['hotemAmenities','hotelRooms'])->findOrFail($id);
                return response()->json([
                    'success'=>true,
                    'status'=>200,
                    'message'=>'Hotel details fetched successfully',
                    'data'=>$hotel
                ]);
        }catch(\Exception $e){
            return response()->json([
               'success'=>false,
               'staus'=>404,
               'message'=>'Failed to fetch hotel details',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        try{
            $data=Hotel::with(['hotemAmenities'])->findOrFail($id);
            return response()->json([
               'success'=>true,
               'status'=>200,
               'message'=>'Hotel fetched successfully',
               'data'=>$data]);
        }
        catch(\Exception $e){
            return response()->json([
               'success'=>false,
               'staus'=>404,
               'message'=>'Failed to edit hotel',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
