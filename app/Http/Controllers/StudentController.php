<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'birthdate' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index')->with('success', '生徒を登録しました');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required',
            'birthdate' => 'required|date',
        ]);

        $student->update($request->all());
        return redirect()->route('students.index')->with('success', '生徒情報を更新しました');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', '生徒を削除しました');
    }
}
