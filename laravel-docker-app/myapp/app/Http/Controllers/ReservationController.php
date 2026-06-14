<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // 予約フォーム表示
    public function create(int $event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('reservations.create', compact('event'));
    }

    // 予約保存
    public function store(Request $request, $event_id)
    {
        $data = $request->except('_token');
        $data['event_id'] = $event_id;

        Reservation::create($data);

        return redirect('/reservations');
    }

    // 予約一覧
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    // 予約キャンセル
    public function destroy(int $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect('/reservations');
    }
}