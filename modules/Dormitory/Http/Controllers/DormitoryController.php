<?php

namespace Modules\Dormitory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dormitory\Entities\Room;
use Illuminate\Contracts\Support\Renderable;
use Modules\Dormitory\DataTables\DormDataTable;
use Modules\Dormitory\Entities\Dormitory;

class DormitoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'permission:dormitory_management']);
        $this->middleware('request:ajax', ['only' => ['store', 'update', 'destroy', 'edit']]);
        \cs_set('theme', [
            'title' => 'Dormitory Lists',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard'),
                ],
                [
                    'name' => 'Dormitory Lists',
                    'link' => false,
                ],
            ],
            'rprefix' => 'admin.dorm',
        ]);
    }

    public function index(DormDataTable $dataTable)
    {
        $rooms = Room::where('status', 1)->get();
        return $dataTable->render('dormitory::dorm.index', compact('rooms'));
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
        // dd($request->all());
        $data = $request->validate([
            'dormitory_name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $dorm = new Dormitory();
        $dorm->fill($request->all());
        $inserted = $dorm->save();

        if (isset($request->room_id)) {
            foreach ($request->room_id as $room) {
                $roomupdate = Room::find($room);
                $roomupdate->dormitories_id = $dorm->id;
                $roomupdate->save();
            }
        }
        return response()->success($inserted, 'Dormitory created successfully.', 201);
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
        $dorm = Dormitory::find($request->id);
        $rooms = Room::where('status', 1)->get();
        $rooms_assigned = Room::where([['status', 1], ['dormitories_id', $request->id]])->pluck('id');

        if (!$dorm) {
            return response()->error(null, 'Room Type not found.', 404);
        }

        return response()->success([
            'dorm' => $dorm,
            'rooms' => $rooms,
            'rooms_assigned' => $rooms_assigned,
        ], 'Dormitory data fetched successfully.', 200);
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
            'id' => 'required',
            'dormitory_name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $dorm = Dormitory::find($data['id']);

        Room::where('dormitories_id', $data['id'])->update([
            'dormitories_id' => null
        ]);

        if (isset($request->room_id)) {
            foreach ($request->room_id as $room) {
                $roomupdate = Room::find($room);
                $roomupdate->dormitories_id = $data['id'];
                $roomupdate->save();
            }
        }

        $updated = $dorm->update($request->all());
        return response()->success($updated, 'Dormitory updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Dormitory $dorm)
    {
        Room::where('dormitories_id', $dorm->id)->update([
            'dormitories_id' => null
        ]);
        $dorm->delete();
        return response()->success(null, 'Dormitory deleted successfully.', 200);
    }
}
