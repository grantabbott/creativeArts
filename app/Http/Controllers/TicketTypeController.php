<?php
namespace App\Http\Controllers;
use App\Http\Requests\TicketTypeRequest;
use App\TicketType;
use App\Classes\Helper;
use Config;

Class TicketTypeController extends Controller{

	public function index(){
	}

	public function show(){
	}

	public function create(){
	}

	public function edit(TicketType $ticket_type){
		return view('ticket_type.edit',compact('ticket_type'));
	}

	public function store(TicketTypeRequest $request, TicketType $ticket_type){	

		$ticket_type->create($request->all());

		return redirect('/configuration#ticket')->withSuccess(config('constants.ADDED'));				
	}

	public function update(TicketTypeRequest $request, TicketType $ticket_type){

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		$ticket_type->fill($request->all())->save();

		return redirect('/configuration#ticket')->withSuccess(config('constants.UPDATED'));
	}

	public function destroy(TicketType $ticket_type){
        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

        $ticket_type->delete();
        return redirect('/configuration#ticket')->withSuccess(config('constants.DELETED'));
	}
}
?>