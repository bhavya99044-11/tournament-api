<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelDates;
class HotelDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $roomDates = [];
        HotelDates::whereHotelId($request->hotel_id)->delete();
        for ($i = 0; $i < count($request->start_date); $i++) {
            if($request->start_date[$i]!=null){
            $roomDates[] = [
                'hotel_id' => $request->hotel_id,
                'start_date' => $request->start_date[$i],
                'end_date' => $request->end_date[$i],
            ];
         }
        }

        // Insert into database
        HotelDates::insert($roomDates);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
                // Store each date range

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(Request $request,string $id)
    {
        try{
        HotelDates::whereId($id)->delete();
        return response()->json(['message' => 'Room date deleted successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete room date'], 500);
        }
    }
}
