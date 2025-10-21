<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.pages.courses', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses',
            'placement_hours' => 'required|integer|min:0',
            'no_of_students' => 'required|integer|min:0',
        ]);

        Course::create($request->all());
        return back()->with('success', 'Course created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:courses,code,' . $id,
            'placement_hours' => 'required|integer|min:0',
            'no_of_students' => 'required|integer|min:0',
        ]);

        $course = Course::findOrFail($id);
        $course->update($request->all());
        return back()->with('success', 'Course updated successfully');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return back()->with('success', 'Course deleted successfully');
    }
}