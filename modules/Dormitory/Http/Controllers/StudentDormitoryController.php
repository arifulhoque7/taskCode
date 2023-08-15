<?php

namespace Modules\Dormitory\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dormitory\Entities\Room;
use Modules\Dormitory\Entities\Dormitory;
use Illuminate\Contracts\Support\Renderable;
use Modules\Dormitory\Entities\StudentDormitory;
use Modules\Dormitory\DataTables\StudentDormDataTable;

class StudentDormitoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'permission:student_dormitory_management']);
        $this->middleware('request:ajax', ['only' => ['store', 'update', 'destroy', 'edit']]);
        \cs_set('theme', [
            'title' => 'Student Dormetory Assign Lists',
            'back' => \back_url(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('admin.dashboard'),
                ],
                [
                    'name' => 'Student Dormetory Assign Lists',
                    'link' => false,
                ],
            ],
            'rprefix' => 'admin.assing_student',
        ]);
    }



    public function index(StudentDormDataTable $dataTable)
    {
        $rooms = Room::where('status', 1)->get();
        $dorms = Dormitory::all();
        $users = User::where('status', 'Active')->get();
        return $dataTable->render('dormitory::student_dorm.index', compact('rooms', 'dorms', 'users'));
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
            'user_id' => 'required|unique:student_dormitories',
            'dormitories_id' => 'required',
            'room_id' => 'required',
        ]);

      
        $roomCheck = Room::find($data['room_id']);

        if($roomCheck->no_of_beds == $roomCheck->booked_beds){
            return response()->error(null, 'Already full Booked!!', 404);
        }
        
        $studentDorm = StudentDormitory::create([
            'user_id' => $data['user_id'],
            'dormitories_id' => $data['dormitories_id'],
            'room_id' => $data['room_id'],
        ]);

        if ($studentDorm) {
            $roomUpdate = Room::find($data['room_id']);
            $roomUpdate->booked_beds = $roomUpdate->booked_beds + 1;
            $roomUpdate->save();
        }

        return response()->success($studentDorm, 'Room Type created successfully.', 201);
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
        $studentDorm = StudentDormitory::find($request->id);

        $rooms = Room::where('status', 1)->get();
        $dorms = Dormitory::all();
        $users = User::where('status', 'Active')->get();

        if (!$studentDorm) {
            return response()->error(null, 'Student Assigned not found.', 404);
        }

        return response()->success([
            'studentDorm' => $studentDorm,
            'rooms' => $rooms,
            'dorms' => $dorms,
            'users' => $users,
        ], 'Student Assigned data fetched successfully.', 200);
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
            'user_id' => 'required|unique:student_dormitories,user_id,'.$request->id,
            'dormitories_id' => 'required',
            'room_id' => 'required',
        ]);

        $studentDorm = StudentDormitory::find($data['id']);

        if ($studentDorm) {
            $roomUpdate = Room::find($studentDorm->room_id);
            $roomUpdate->booked_beds = $roomUpdate->booked_beds - 1;
            $roomUpdate->save();
        }

        $roomCheck = Room::find($data['room_id']);
        
        if($roomCheck->no_of_beds == $roomCheck->booked_beds){
            return response()->error(null, 'Already full Booked!!', 404);
        }


        $updated = $studentDorm->update($request->all());

        if ($studentDorm) {
            $roomUpdateNew = Room::find($data['room_id']);
            $roomUpdateNew->booked_beds = $roomUpdateNew->booked_beds + 1;
            $roomUpdateNew->save();
        }

        return response()->success($updated, 'Dormitory updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(StudentDormitory $studentDorm)
    {

        if ($studentDorm) {
            $roomupdate = Room::find($studentDorm->room_id);
            $roomupdate->booked_beds = $roomupdate->booked_beds - 1;
            $roomupdate->save();
        }

        $studentDorm->delete();

        return response()->success(null, 'Room Type deleted successfully.', 200);
    }
    public function get_rooms_data(Request $request)
    {
        $allRooms = Room::where('dormitories_id', $request->dorm_id)->get();

        return response()->success([
            'allRooms' => $allRooms
        ], 'okay', 200);
    }
}
