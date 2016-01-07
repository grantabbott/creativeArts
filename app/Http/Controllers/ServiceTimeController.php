<?php
namespace App\Http\Controllers;
use App\Http\Requests\ServiceTimeRequest;
use App\ServiceTime;
use App\Classes\Helper;

Class ServiceTimeController extends Controller{

	public function index(){
	}

	public function show(){
	}

	public function create(){
	}

	public function edit(ServiceTime $service_time){
        $priority = config('list.priority');
        $time_unit = config('list.time_unit');
        $time_type = config('list.time_type');

		return view('service_time.edit',compact('service_time','priority','time_unit','time_type'));
	}

	public function store(ServiceTimeRequest $request, ServiceTime $service_time){

		$service_time->create($request->all());

		return redirect('/configuration#service_time')->withSuccess(config('constants.ADDED'));
	}

	public function update(ServiceTimeRequest $request, ServiceTime $service_time){

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		$service_time->fill($request->all())->save();

		return redirect('/configuration#service_time')->withSuccess(config('constants.UPDATED'));
	}

	public function destroy(ServiceTime $service_time){
        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        $service_time->delete();
        return redirect('/configuration#service_time')->withSuccess(config('constants.DELETED'));
	}
}