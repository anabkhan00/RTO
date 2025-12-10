<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlacementAssignment;
use App\Models\StudentDocument;

class UserController extends Controller
{
    public function dashboard()
    {
        $assignments = PlacementAssignment::with(['opportunity.industry', 'opportunity.sourcingCoordinator', 'placementCoordinator'])
            ->where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        $placementCount = $assignments->count();
        
        return view('user.dashboard', compact('assignments', 'placementCount'));
    }

    public function placements()
    {
        $assignments = PlacementAssignment::with(['opportunity.industry', 'opportunity.sourcingCoordinator', 'placementCoordinator'])
            ->where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.pages.placements', compact('assignments'));
    }

    public function documents()
    {
        $documents = StudentDocument::where('student_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.pages.documents', compact('documents'));
    }
}