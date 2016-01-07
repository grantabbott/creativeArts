<?php
namespace App\Http\Controllers;
use App\Http\Requests\BusinessHourRequest;
use App\BusinessHour;
use App\Classes\Helper;

Class BusinessHourController extends Controller{

	public function index(){
	}

	public function show(){
	}

	public function create(){
	}

	public function edit(BusinessHour $business_hour){
        $week_days = config('list.week');

		return view('business_hour.edit',compact('business_hour','week_days'));
	}

	public function store(BusinessHourRequest $request, BusinessHour $business_hour){

		if($request->input('start') > $request->input('end'))
			return redirect()->back()->withErrors('End time cannot be greater than start time.');

		$business_hour->create($request->all());

		return redirect('/configuration#business_hour')->withSuccess(config('constants.ADDED'));
	}

	public function update(BusinessHourRequest $request, BusinessHour $business_hour){

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		if($request->input('start') > $request->input('end'))
			return redirect()->back()->withErrors('End time cannot be greater than start time.');

		$business_hour->fill($request->all())->save();

		return redirect('/configuration#business_hour')->withSuccess(config('constants.UPDATED'));
	}

	public function destroy(BusinessHour $business_hour){
        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        $business_hour->delete();
        return redirect('/configuration#business_hour')->withSuccess(config('constants.DELETED'));
	}
}