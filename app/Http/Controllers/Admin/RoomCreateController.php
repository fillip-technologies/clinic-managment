<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomCreate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomCreateController extends Controller
{
    public function roomListing()
    {
        $rooms = RoomCreate::paginate(10) ?? [];
        return view('admin.rooms.create', compact('rooms'));
    }

    public function roomStore(Request $request)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'room_type' => 'required|string|in:public,private,team,channel',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'members' => 'nullable|array',
            'members.*' => 'string|max:255',
        ]);

        $imagePath = null;

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('rooms', $imageName, 'public');
        }


        RoomCreate::create([
            'room_name'       => $request->room_name,
            'room_type'       => $request->room_type,
            'members'    => json_encode($request->members),
            'file'      => $imagePath,
            'created_by' => Auth::guard('super_admin')->id(),
        ]);



        return redirect()->back()->with('success', 'Room created successfully.');
    }

    public function roomUpdated(Request $request, $id)
    {

        $room = RoomCreate::findOrFail($id);

        $request->validate([
            'room_name' => 'required|string|max:255',
            'room_type' => 'required|string|in:public,private,team,channel',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'members' => 'nullable|array',
            'members.*' => 'string|max:255',
            'remove_image' => 'nullable|boolean'
        ]);


        if ($request->boolean('remove_image') && $room->image) {
            Storage::disk('public')->delete($room->image);
            $room->image = null;
        }


        if ($request->hasFile('file')) {

            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }

            $room->image = $request->file('file')
                ->store('rooms', 'public');
        }

        $room->room_name = $request->room_name;
        $room->room_type = $request->room_type;
        $room->members = json_encode($request->members);
        $room->save();

        return redirect()->back()->with('success', 'Room updated successfully.');
    }
    public function roomDelete($id)
    {
        $room = RoomCreate::findOrFail($id);
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }
        RoomCreate::where('room_name', $room->room_name)->delete();

        return response()->json([
            "message"=>"Room deleted successFully",
            "datas"=>$room
        ],200);

    }

    public function roomEdit($id)
    {
        $editroom = RoomCreate::find($id);
        $rooms = RoomCreate::paginate(10) ?? [];
        return view('admin.rooms.create', compact('editroom', 'rooms'));
    }

    public function indexmember($id, $index)
    {
        $room = RoomCreate::findOrFail(trim($id));

        $members = json_decode($room->members, true);

        if (!isset($members[$index])) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        $deletedMember = $members[$index];
        unset($members[$index]);
        $members = array_values($members);
        $room->members = json_encode($members);
        $room->save();

        return response()->json([
            'message' => 'Member deleted successfully',
            'data' => $deletedMember,
            'members' => $members
        ], 200);
    }
}
