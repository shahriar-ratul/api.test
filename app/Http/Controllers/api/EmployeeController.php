<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeInfo;
use App\Http\Requests\UpdateEmployeeInfo;
use App\Http\Resources\EmployeeCollectionResource;
use App\Http\Resources\EmployeeResource;
use App\model\Employee;
use App\model\EmployeeInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmployeeCollectionResource::collection(Employee::paginate(20));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeInfo $request)
    {
        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->company_id = $request->company_id;
        $employee->save();

        $employee_info = new EmployeeInfo();
        $employee_info->birthday = Carbon::now();
        $employee_info->employee_id = $employee->id;
        $employee_info->save();
        return response([
            'data' => new EmployeeResource($employee)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeInfo $request, $id)
    {
       Employee::findOrFail($id)->update(['name' => $request->name,'email' =>  $request->email , 'company_id' => $request->company_id ]);
        $employee = Employee::find($id);
        return response([
            'data' => new EmployeeResource($employee)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(["message"=>"Employee deleted Successfully"],200);
    }
}
