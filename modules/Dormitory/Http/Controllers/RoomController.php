<?php

namespace Modules\Dormitory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dormitory\DataTables\RoomDataTable;
use Modules\Dormitory\Entities\Room;
use Modules\Dormitory\Entities\RoomType;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'permission:room_management']);
        $this->middleware('request:ajax', ['only' => ['store', 'update', 'destroy', 'edit']]);
        \cs_set('theme', [
            'title' => 'Room Lists',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard'),
                ],
                [
                    'name' => 'Room Lists',
                    'link' => false,
                ],
            ],
            'rprefix' => 'admin.room',
        ]);
    }

    public function index(RoomDataTable $dataTable)
    {
        $roomTypes = RoomType::where('status', 1)->get();
        return $dataTable->render('dormitory::room.index', compact('roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('dormitory::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_type_id' => 'required',
            'no_of_beds' => 'required',
            'status' => 'required|integer',
        ]);

        $room = new Room();
        $room->fill($request->all());
        $inserted = $room->save();

        return response()->success($inserted, 'Room Type created successfully.', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('dormitory::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request)
    {
        $room = Room::find($request->id);
        $roomTypes = RoomType::where('status', 1)->get();
        if (! $room) {
            return response()->error(null, 'Room Type not found.', 404);
        }

        return response()->success([
            'room' => $room,
            'roomTypes' => $roomTypes
        ], 'Room data fetched successfully.', 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:rooms,id',
            'room_type_id' => 'required',
            'no_of_beds' => 'required',
            'status' => 'required|integer',
        ]);
        
        $room = Room::find($data['id']);
        $updated = $room->update($request->all());
        return response()->success($updated, 'Room Type updated successfully.', 200);
       
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->success(null, 'Room deleted successfully.', 200);
    }
}
