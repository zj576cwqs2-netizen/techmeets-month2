<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Event;

class EventController extends Controller
{
    // イベント一覧
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    // イベント詳細
    public function show(int $id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }
}