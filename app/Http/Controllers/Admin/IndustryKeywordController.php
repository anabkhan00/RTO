<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SavedIndustryKeyword;
use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryKeywordController extends Controller
{
    public function search(Request $request)
    {
        try {
            $keyword = $request->get('keyword', '');
            $results = Industry::where('name', 'like', "%{$keyword}%")
                ->limit(20)
                ->pluck('name')
                ->toArray();

            return response()->json(['results' => $results]);
        } catch (\Exception $e) {
            return response()->json(['results' => []]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'industry_name' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        SavedIndustryKeyword::create([
            'coordinator_id' => auth()->id(),
            'keyword' => $request->keyword,
            'industry_name' => $request->industry_name,
            'notes' => $request->notes
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $keyword = SavedIndustryKeyword::findOrFail($id);

        $keyword->update([
            'keyword' => $request->keyword,
            'industry_name' => $request->industry_name,
            'notes' => $request->notes
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        SavedIndustryKeyword::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function getAll()
    {
        $keywords = SavedIndustryKeyword::with('coordinator')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['keywords' => $keywords]);
    }

    public function index()
    {
        return view('admin.pages.industry_keywords');
    }
}
