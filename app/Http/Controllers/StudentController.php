<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['success'=>true, 'message'=>'Successfully retrieved student data']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'name'=>['required'],
        //     'email'=>['required', 'email'],
        //     'photo'=>['required']
        // ]);

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|unique:students,email',
            'photo'=>'required'
        ]);


        if($validator ->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }


        $student = new Student;

        $fn = time().'.'.$request->photo->extension();

        $request->photo->move(public_path('uploads'), $fn);

        $student->name = $request->name;
        $student->email = $request->email;
        $student->photo = $fn;

        $student->save();

        return response()->json([
            'success'=>true,
            'status_code'=>201,
            'message'=>'Successfully inserted student data',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
