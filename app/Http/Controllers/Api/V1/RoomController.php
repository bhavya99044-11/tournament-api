<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomTypes;

class RoomController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roomCreate=Room::create([
            'name'=>$request->name,
            'hotel_id' => $request->hotel_id,
            'meal_plan' => $request->meal,
        ]);
        foreach($request->room as $room){
            RoomTypes::create([
                'room_id' => $roomCreate->id,
                'type' => $room,
            ]);
        }
        return response()->json(['status'=>200,'message'=>'Room created successfully'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
          $room = Room::with('roomTypes')->findOrFail($id); // Eager load room types
        return response()->json(['status' => 200, 'data' => $room], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);
        $room->name=$request->name;
        $room->meal_plan=$request->meal;
        $room->save();
        if ($request->has('room')) {
            $room->roomTypes()->delete();
            foreach ($request->room as $type) {
                RoomTypes::create([
                    'room_id' => $room->id,
                    'type' => $type,
                ]);
            }
        }
        return response()->json(['status' => 200, 'message' => 'Room updated successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['status' => 200,'message' => 'Room deleted successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['status' => 500,'message' => 'Failed to delete room'], 500);
        }
    }
}
