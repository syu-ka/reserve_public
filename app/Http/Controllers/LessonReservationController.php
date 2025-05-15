<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonReservationController extends Controller
{
    public function index()
    {
        // // Fetch all reservations for the authenticated user
        // $user = auth()->user();
        // $reservations = $user->reservations()->with('lesson')->get();

        // return view('reservations.index', compact('reservations'));
        return view('reservations.index');
    }
}
