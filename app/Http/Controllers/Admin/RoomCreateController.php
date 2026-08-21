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
        $rooms = RoomCreate::latest()->paginate(10);
        return view('admin.rooms.create', compact('rooms'));
    }

    public function roomStore(Request $request)
    {
        $request->validate([
            'room_name' => 'required|string|max:255',
            'room_type' => 'required|string|in:public,private,team,channel',
            'files'     => 'nullable|array',
            'files.*'   => 'file|max:20480', // Support all file types up to 20MB
            'file'      => 'nullable',
            'members'   => 'nullable|array',
            'members.*' => 'string|max:255',
        ]);

        $filePaths = [];

        // Handle multiple file upload
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                    $fileName = time() . '_' . uniqid() . '_' . $cleanName . '.' . $extension;
                    $path = $file->storeAs('rooms', $fileName, 'public');
                    $filePaths[] = $path;
                }
            }
        } elseif ($request->hasFile('file')) {
            $file = $request->file('file');
            if (is_array($file)) {
                foreach ($file as $f) {
                    if ($f->isValid()) {
                        $originalName = pathinfo($f->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = $f->getClientOriginalExtension();
                        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $fileName = time() . '_' . uniqid() . '_' . $cleanName . '.' . $extension;
                        $path = $f->storeAs('rooms', $fileName, 'public');
                        $filePaths[] = $path;
                    }
                }
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $fileName = time() . '_' . uniqid() . '_' . $cleanName . '.' . $extension;
                $path = $file->storeAs('rooms', $fileName, 'public');
                $filePaths[] = $path;
            }
        }

        // Store multiple files as a single comma-separated string using implode()
        $implodedFiles = !empty($filePaths) ? implode(',', $filePaths) : null;

        RoomCreate::create([
            'room_name'  => $request->room_name,
            'room_type'  => $request->room_type,
            'members'    => json_encode($request->members ?? []),
            'file'       => $implodedFiles,
            'created_by' => Auth::guard('super_admin')->id() ?? Auth::id() ?? 1,
        ]);

        return redirect()->back()->with('success', 'Room created successfully with attached files.');
    }

    public function roomUpdated(Request $request, $id)
    {
        $room = RoomCreate::findOrFail($id);

        $request->validate([
            'room_name'        => 'required|string|max:255',
            'room_type'        => 'required|string|in:public,private,team,channel',
            'files'            => 'nullable|array',
            'files.*'          => 'file|max:20480',
            'file'             => 'nullable',
            'members'          => 'nullable|array',
            'members.*'        => 'string|max:255',
            'removed_files'    => 'nullable|array',
            'remove_all_files' => 'nullable|boolean'
        ]);

        // Retrieve existing files from DB by exploding the string into an array
        $existingFiles = !empty($room->file) ? array_values(array_filter(explode(',', $room->file))) : [];

        // Handle remove all files
        if ($request->boolean('remove_all_files')) {
            foreach ($existingFiles as $f) {
                if (Storage::disk('public')->exists($f)) {
                    Storage::disk('public')->delete($f);
                }
            }
            $existingFiles = [];
        }

        // Handle removing specific selected files
        if ($request->has('removed_files') && is_array($request->removed_files)) {
            foreach ($request->removed_files as $fileToRemove) {
                if (($key = array_search($fileToRemove, $existingFiles)) !== false) {
                    if (Storage::disk('public')->exists($fileToRemove)) {
                        Storage::disk('public')->delete($fileToRemove);
                    }
                    unset($existingFiles[$key]);
                }
            }
            $existingFiles = array_values($existingFiles);
        }

        // Handle newly uploaded files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                    $fileName = time() . '_' . uniqid() . '_' . $cleanName . '.' . $extension;
                    $path = $file->storeAs('rooms', $fileName, 'public');
                    $existingFiles[] = $path;
                }
            }
        } elseif ($request->hasFile('file')) {
            $file = $request->file('file');
            if (is_array($file)) {
                foreach ($file as $f) {
                    if ($f->isValid()) {
                        $originalName = pathinfo($f->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = $f->getClientOriginalExtension();
                        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                        $fileName = time() . '_' . uniqid() . '_' . $cleanName . '.' . $extension;
                        $path = $f->storeAs('rooms', $fileName, 'public');
                        $existingFiles[] = $path;
                    }
                }
            } else {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
                $fileName = time() . '_' . uniqid() . '_' . $cleanName . '.' . $extension;
                $path = $file->storeAs('rooms', $fileName, 'public');
                $existingFiles[] = $path;
            }
        }

        // Save the updated files list back to database using implode()
        $room->file = !empty($existingFiles) ? implode(',', $existingFiles) : null;
        $room->room_name = $request->room_name;
        $room->room_type = $request->room_type;
        $room->members = json_encode($request->members ?? []);
        $room->save();

        return redirect()->route('room.list')->with('success', 'Room updated successfully.');
    }

    public function roomDelete($id)
    {
        $room = RoomCreate::findOrFail($id);

        // Explode file string to delete all associated files from storage
        if (!empty($room->file)) {
            $files = array_filter(explode(',', $room->file));
            foreach ($files as $filePath) {
                $filePath = trim($filePath);
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        $room->delete();

        return response()->json([
            "message" => "Room deleted successfully",
            "datas"   => $room
        ], 200);
    }

    public function roomEdit($id)
    {
        $editroom = RoomCreate::findOrFail($id);
        $rooms = RoomCreate::latest()->paginate(10);
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

    public function deleteRoomFile($id, $index)
    {
        $room = RoomCreate::findOrFail($id);

        // Explode database string to array
        $files = !empty($room->file) ? array_values(array_filter(explode(',', $room->file))) : [];

        if (!isset($files[$index])) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $fileToDelete = $files[$index];
        if (Storage::disk('public')->exists($fileToDelete)) {
            Storage::disk('public')->delete($fileToDelete);
        }

        unset($files[$index]);
        $files = array_values($files);

        // Implode array back to string
        $room->file = !empty($files) ? implode(',', $files) : null;
        $room->save();

        return response()->json([
            'message' => 'File deleted successfully',
            'files'   => $files
        ], 200);
    }
}
