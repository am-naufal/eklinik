<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rooms = Room::all();
            $data = [];

            foreach ($rooms as $room) {
                $data[] = [
                    'room_number' => $room->room_number,
                    'name' => $room->name,
                    'room_type' => $room->room_type,
                    'floor' => $room->floor,
                    'capacity' => $room->capacity,
                    'price_per_day' => $room->price_per_day,
                    'status' => $room->status,
                    'status_badge' => view('admin.rooms.status-badge', compact('room'))->render(),
                    'action' => view('admin.rooms.action', compact('room'))->render(),
                ];
            }

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
                'data' => $data
            ]);
        }

        return view('admin.rooms.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'name' => 'required|string|max:255',
            'room_type' => 'required',
            'floor' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string'
        ]);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruang rawat inap berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id,
            'name' => 'required|string|max:255',
            'room_type' => 'required',
            'floor' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string'
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Ruang rawat inap berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        if ($room->inpatients()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus ruangan yang sedang digunakan'
            ], 422);
        }

        $room->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ruang rawat inap berhasil dihapus'
        ]);
    }
}
