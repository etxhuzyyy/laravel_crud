<?php

namespace App\Http\Controllers;

use App\Models\EmployeeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = EmployeeModel::orderBy('id','DESC')->paginate(5);
        return view('employee.list',['employees' => $employees]);
    }
    public function create()
    {
        return view('employee.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image:gif,png,jpeg,jpg'
        ]);
        
        if($validator->passes())
        {
            // Save data here 
            $employee = new EmployeeModel();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();
            
            //Upload image here
            if($request->image)
            {
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().'.'.$ext;
                $request->image->move(public_path().'/uploads/employees/',$newFileName);
                $employee->image = $newFileName;
                $employee->save();
            }
            return redirect()->route('employees.index')->with('success','Employee added successfully.');;


        }
        else
        {
            //Return with errors
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }
    }
    public function edit($id) 
    {
        $employee = EmployeeModel::findOrFail($id);
        return view('employee.edit',['employee' => $employee]);
    }
    public function update($id,Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image:gif,png,jpeg,jpg'
        ]);
        
        if($validator->passes())
        {
            // Save data here 
            $employee = EmployeeModel::find($id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();
            
            //Upload image here
            if($request->image)
            {
                $oldImage = $employee->image;
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().'.'.$ext;
                $request->image->move(public_path().'/uploads/employees/',$newFileName);
                $employee->image = $newFileName;
                $employee->save();
                File::delete(public_path().'/uploads/employees/',$oldImage);
            }
            return redirect()->route('employees.index')->with('success','Employee updated successfully.');;


        }
        else
        {
            //Return with errors
            return redirect()->route('employees.edit',$id)->withErrors($validator)->withInput();
        }
    }
    public function destroy($id, Request $request)
{
    $employee = EmployeeModel::findOrFail($id);
    File::delete(public_path().'/uploads/employees/'.$employee->image); // Delete the associated image file (if any)
    $employee->delete();
    return redirect()->route('employees.index')->with('success','Employee deleted successfully.');
}
}
