<?php

namespace App\Http\Controllers;

use App\Models\StudentNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentNoteController extends Controller
{
    public function store(Request $request, $studentId)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $userRole = $user->getRoleNames()->first() ?? 'user';

        $note = StudentNote::create([
            'student_id' => $studentId,
            'author_id' => $user->id,
            'content' => $request->content,
            'author_role' => $userRole
        ]);

        $note->load('author');

        return response()->json([
            'success' => true,
            'note' => [
                'id' => $note->id,
                'content' => $note->content,
                'author_role' => $note->author_role,
                'author_name' => $note->author->name,
                'author_id' => $note->author_id,
                'created_at' => $note->created_at->format('M j, Y')
            ]
        ]);
    }

    public function update(Request $request, $studentId, $noteId)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $note = StudentNote::where('student_id', $studentId)->findOrFail($noteId);

        if ($note->author_id !== Auth::id()) {
            return response()->json(['success' => false], 403);
        }

        $note->update(['content' => $request->content]);

        return response()->json([
            'success' => true,
            'note' => [
                'id' => $note->id,
                'content' => $note->content,
                'author_role' => $note->author_role,
                'author_name' => $note->author->name,
                'author_id' => $note->author_id,
                'created_at' => $note->created_at->format('M j, Y')
            ]
        ]);
    }

    public function index($studentId)
    {
        $notes = StudentNote::where('student_id', $studentId)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'notes' => $notes->map(function($note) {
                return [
                    'content' => $note->content,
                    'author_role' => $note->author_role,
                    'author_name' => $note->author->name,
                    'created_at' => $note->created_at->format('M j, Y')
                ];
            })
        ]);
    }
}
