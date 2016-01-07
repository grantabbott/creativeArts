<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\AnnoucementRequest;
use Entrust;
use Config;
use App\Annoucement;
use App\Role;
use App\Classes\Helper;
use Auth;
use Activity;

Class AnnoucementController extends Controller{

	protected $form = 'annoucement-form';

	public function index(Annoucement $annoucement){

		if(!Entrust::can('manage_annoucement'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$annoucements = $annoucement->get();

        $col_data=array();
        $col_heads = array(
        		trans('messages.Option'),
        		trans('messages.Title'),
        		trans('messages.Scope'),
        		trans('messages.Start Date'),
        		trans('messages.End Date')
        		);

        $col_heads = Helper::putCustomHeads($this->form, $col_heads);
        $col_ids = Helper::getCustomColId($this->form);
        $values = Helper::fetchCustomValues($this->form);

        foreach($annoucements as $annoucement){

        	$role_name = "<ol class='nl'>";
        	foreach($annoucement->Role as $role){
			    $role_name .= "<li>$role->display_name</li>";
			}
        	$role_name .= "</ol>";

			$cols = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="annoucement/'.$annoucement->id.'/edit" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit"> <i class="fa fa-edit"></i></a> '.
				delete_form(['annoucement.destroy',$annoucement->id]).'</div>',
				$annoucement->annoucement_title,
				$role_name,
				Helper::showDate($annoucement->start_date),
				Helper::showDate($annoucement->end_date)
				);	
			$id = $annoucement->id;

			foreach($col_ids as $col_id)
				array_push($cols,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
        	$col_data[] = $cols;
			
        }

        Helper::writeResult($col_data);

		return view('annoucement.index',compact('col_heads'));
	}

	public function show(){
	}

	public function create(){

		if(!Entrust::can('create_annoucement'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$roles = Role::lists('display_name','id')->all();

		return view('annoucement.create',compact('roles'));
	}

	public function edit(Annoucement $annoucement){

		if(!Entrust::can('edit_annoucement'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));
		
		$selected_roles = array();

		foreach($annoucement->Role as $role){
			$selected_roles[] = $role->id;
		}

		$roles = Role::lists('display_name','id')->all();

		$custom_field_values = Helper::getCustomFieldValues($this->form,$annoucement->id);
		return view('annoucement.edit',compact('roles','annoucement','selected_roles','custom_field_values'));
	}

	public function store(AnnoucementRequest $request, Annoucement $annoucement){

		if(!Entrust::can('create_annoucement'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$data = $request->all();
	    $annoucement->fill($data);
		$annoucement->user_id = Auth::user()->id;
		$annoucement->save();
	    $annoucement->role()->sync(($request->input('role_id')) ? : []) ;
		Helper::storeCustomField($this->form,$annoucement->id, $data);
		$activity = 'Published an annoucement';
		Activity::log($activity);

		return redirect()->back()->withSuccess(config('constants.SAVED'));		
	}

	public function update(AnnoucementRequest $request, Annoucement $annoucement){

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		if(!Entrust::can('edit_annoucement'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$data = $request->all();
		$annoucement->fill($data);
		$annoucement->save();
	    $annoucement->role()->sync(($request->input('role_id')) ? : []) ;
		Helper::updateCustomField($this->form,$annoucement->id, $data);
		$activity = 'Edit an annoucement';
		Activity::log($activity);
		return redirect('/annoucement')->withSuccess(config('constants.SAVED'));
	}

	public function destroy(Annoucement $annoucement){
		if(!Entrust::can('delete_annoucement'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		Helper::deleteCustomField($this->form, $annoucement->id);
        $annoucement->delete();
		$activity = 'Deleted a annoucement';
		Activity::log($activity);

        return redirect('/annoucement')->withSuccess(config('constants.DELETED'));
	}
}
?>