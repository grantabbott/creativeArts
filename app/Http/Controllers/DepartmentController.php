<?php
namespace App\Http\Controllers;
use App\Http\Requests\DepartmentRequest;
use App\Department;
use App\Classes\Helper;

Class DepartmentController extends Controller{

	public function index(){
	}

	public function show(){
	}

	public function create(){
	}

	public function edit(Department $department){
		return view('department.edit',compact('department'));
	}

	public function store(DepartmentRequest $request, Department $department){	

		$department->create($request->all());

		return redirect('/configuration#department')->withSuccess(config('constants.ADDED'));				
	}

	public function update(DepartmentRequest $request, Department $department){

		$department->fill($request->all())->save();

		return redirect('/configuration#department')->withSuccess(config('constants.UPDATED'));
	}

	public function destroy(Department $department){
        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        $department->delete();
        return redirect('/configuration#department')->withSuccess(config('constants.DELETED'));
	}
}
?>