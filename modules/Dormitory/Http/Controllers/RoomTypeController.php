<?php

namespace Modules\Dormitory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dormitory\Entities\RoomType;
use Modules\Dormitory\DataTables\RoomTypeDataTable;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

     public function __construct()
    {
        $this->middleware(['auth', 'verified', 'permission:room_type_management']);
        $this->middleware('request:ajax', ['only' => ['store', 'update', 'destroy', 'edit']]);
        \cs_set('theme', [
            'title' => 'Room Type Lists',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard'),
                ],
                [
                    'name' => 'Room Type Lists',
                    'link' => false,
                ],
            ],
            'rprefix' => 'admin.room_types',
        ]);
    }


    public function index(RoomTypeDataTable $dataTable)
    {
        return $dataTable->render('dormitory::room_types.index');
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
            'room_type' => 'required|string|max:255',
            'status' => 'integer',
        ]);

        $roomType = RoomType::create([
            'room_type' => $data['room_type'],
            'status' => $data['status'],
        ]);

        return response()->success($roomType, 'Room Type created successfully.', 201);
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
        $roomType = RoomType::find($request->id);
        if (! $roomType) {
            return response()->error(null, 'Room Type not found.', 404);
        }

        return response()->success([
            'roomType' => $roomType
        ], 'Room Type data fetched successfully.', 200);
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
            'id' => 'required|exists:room_types,id',
            'edit_room_type' => 'required|string|max:255',
            'edit_status' => 'integer'

        ]);
        $roomType = RoomType::find($data['id']);
        $roomType->update([
            'room_type' => $data['edit_room_type'],
            'status' => $data['edit_status'],
        ]);

        return response()->success($roomType, 'Room Type updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        return response()->success(null, 'Room Type deleted successfully.', 200);
    }
}
