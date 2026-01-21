<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Audit::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('auditable_type')) {
            $query->where('auditable_type', $request->auditable_type);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('auditable_id', 'like', '%' . $request->search . '%')
                  ->orWhere('event', 'like', '%' . $request->search . '%');
            });
        }

        $audits = $query->paginate(50);

        return view('admin.pages.audits', compact('audits'));
    }

    public function show($id)
    {
        $audit = Audit::with('user')->findOrFail($id);
        return response()->json($audit);
    }

    public function studentHistory($studentId)
    {
        $audits = Audit::with('user')
            ->where(function($query) use ($studentId) {
                $query->where('auditable_type', 'App\\Models\\User')
                      ->where('auditable_id', $studentId)
                      ->orWhere(function($q) use ($studentId) {
                          $q->where('auditable_type', 'App\\Models\\StudentDetail')
                            ->whereHas('auditable', function($sq) use ($studentId) {
                                $sq->where('user_id', $studentId);
                            });
                      })
                      ->orWhere(function($q) use ($studentId) {
                          $q->where('auditable_type', 'App\\Models\\StudentDocument')
                            ->where('auditable_id', $studentId);
                      });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($audits);
    }
}
