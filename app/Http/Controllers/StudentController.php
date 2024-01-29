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

        $students = Student::all();

        return response()->json(['success'=>true,'status_code'=>200, 'message'=>'Successfully retrieved student data', 'data'=>$students]);
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
            return response()->json(['success'=>false, 'status_code'=>400, 'messsage'=>'Validation error','error'=>$validator->errors()]);
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

        return response()->json(['success'=>true, 'status_code'=>200, 'message'=>'Success retrieved data by id', 'data'=>$student]);
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
        if($request->name){
            $student->name = $request->name;
        }
        if($request->email){
            $student->email = $request->email;
        }
        if($request->photo){
            unlink(public_path('uploads/'. $request->photo));
            $student->photo = $request->photo;
        }

        $student->update();

        // info($request);

        return response()->json([
            'success'=>true,
            'status_code'=>200,
            'message'=>'Successfully updated data'
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
