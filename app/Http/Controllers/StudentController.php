<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return new StudentResource($students, 'Success', 'List of Students.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate =  Validator::make($request->all(), [
            'nim' => 'required',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);


        if ($validate->fails()) {
            return new StudentResource(null, 'Failed', $validate->errors());
        }

        $student = Student::create($request->all());
        return new StudentResource($student, 'Success', 'Successfully created student data.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return new StudentResource(null, 'Failed', 'Student not found.');
        }
        return new StudentResource($student, 'Success', 'Student found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->update($request->all());
            return new StudentResource($student, 'Success', 'Data edited succesfully');
        }
        return new StudentResource(null, 'Failed', 'Error Occured.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return new StudentResource($student, 'Success', 'Successfully Deleted');
        }
        return new StudentResource(null, 'Failed', 'Error Occured.');
    }
}
