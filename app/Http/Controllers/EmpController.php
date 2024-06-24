<?php

namespace App\Http\Controllers;
use DataTables;
use App\Models\emp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EmpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        // $maxSalary = emp::max('salary');
        $maxSalary = emp::select('salary')->orderBy('salary', 'desc')->skip(1)->take(10)->get();
        // $HighestSalary = emp::select('salary')
        //     ->distinct()
        //     ->orderBy('salary', 'desc')
        //     ->take(1)
        //     ->first();
        // foreach($maxSalary as $salary){
        //     print_r('$salary');
        //     exit();
        // }
        foreach ($maxSalary as $salary) {
            echo $salary->salary . "<br>";
        }
        // echo "<br>";
        // print_r($HighestSalary->salary);

        // if ($request->ajax()) {
        //     $data = emp::select('id','name','salary')->get();
        //     $data = emp::select('salary')->orderBy('salary', 'desc')->skip(1)->first();
        //     return Datatables::of($data)->addIndexColumn()
        //         ->addColumn('action', function($emp){
        //             // $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm m-1">View</a>';
        //             $btn = '<a href="/employees/'. $emp->id .'/edit" class="btn btn-info btn-sm m-1">Edit</a>';
        //             $btn .= '<button class="btn btn-danger btn-sm m-1 delete-button" data-id="'. $emp->id .'">Delete</button>';
        //             return $btn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

        // return view('employees.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(emp $emp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(emp $emp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, emp $emp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(emp $emp)
    {
        $emp = emp::find($id);

        if ($emp) {
            $emp->delete();
            return Response::json(['success' => 'Employees deleted successfully.']);
        }

        return Response::json(['error' => 'Employees not found.'], 404);
    }
}
