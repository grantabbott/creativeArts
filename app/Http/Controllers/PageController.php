<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use Entrust;
use Config;
use App\Page;
use App\Classes\Helper;
use Auth;
use Activity;
use File;

Class PageController extends Controller{

	protected $form = 'page-form';

	public function index(Page $page){

		if(!Entrust::can('manage_page'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$pages = $page->get();

        $col_data=array();
        $col_heads = array(
        		trans('messages.Option'),
        		trans('messages.Title'),
        		trans('messages.Published'),
        		trans('messages.Sign-in Only')
        		);

        $col_heads = Helper::putCustomHeads($this->form, $col_heads);
        $col_ids = Helper::getCustomColId($this->form);
        $values = Helper::fetchCustomValues($this->form);

        foreach($pages as $page){

			$cols = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="page/'.$page->id.'/edit" class="btn btn-default btn-xs" data-toggle="tooltip" title="Edit"> <i class="fa fa-edit"></i></a> '.
				delete_form(['page.destroy',$page->id]).'</div>',
				$page->page_title,
				($page->published) ? '<span class="badge badge-success">Publised</span>' : '<span class="badge badge-danger">Hold</span>',
				($page->sign_in_only) ? '<span class="badge badge-warning">Sign-in Only</span>' : '<span class="badge badge-info">All</span>'
				);	
			$id = $page->id;

			foreach($col_ids as $col_id)
				array_push($cols,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
        	$col_data[] = $cols;
			
        }

        Helper::writeResult($col_data);

		return view('page.index',compact('col_heads'));
	}

	public function defaultPage(){
		return view('page.default_page');
	}

	public function saveDefaultPage(Request $request){
		
        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		$pages = Helper::getPages();
		$pages['homepage']['title'] = $request->input('homepage_title');
		$pages['homepage']['description'] = $request->input('homepage');
		$pages['business_hour']['title'] = $request->input('business_hour_title');
		$pages['business_hour']['description'] = $request->input('business_hour');
		$pages['terms_and_conditions']['title'] = $request->input('terms_and_conditions_title');
		$pages['terms_and_conditions']['description'] = $request->input('terms_and_conditions');

		$filename = base_path().config('paths.PAGE_PATH');
		File::put($filename,var_export($pages, true));
		File::prepend($filename,'<?php return ');
		File::append($filename, ';');

		return redirect()->back()->withSuccess(config('constants.SAVED'));
	}

	public function showBusinessHour(){
		if(!config('config.show_business_hour'))
			return redirect('/');

		$business_hours = \App\BusinessHour::all();
		$service_times = \App\ServiceTime::all();
		$assets = ['hide_sidebar'];

		return view('page.business_hour',compact('assets','business_hours','service_times'));
	}

	public function showTermsAndConditions(){
		if(!config('config.show_terms_and_conditions'))
			return redirect('/');
		$assets = ['hide_sidebar'];
		return view('page.terms_and_conditions',compact('assets'));
	}

	public function view($slug){
		$page = Page::where('page_slug','=',$slug)->first();

		if(!$page)
			return redirect('/')->withErrors(config('constants.NA'));

		if($page->sign_in_only && !Auth::check())
			return redirect('/')->withErrors(config('constants.NA'));

		$assets = ['hide_sidebar'];
		return view('page.view',compact('page','assets'));
	}

	public function show(){
	}

	public function create(){

		if(!Entrust::can('create_page'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		return view('page.create');
	}

	public function edit(Page $page){

		if(!Entrust::can('edit_page'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));
		
		$custom_field_values = Helper::getCustomFieldValues($this->form,$page->id);
		return view('page.edit',compact('page','custom_field_values'));
	}

	public function store(PageRequest $request, Page $page){

		if(!Entrust::can('create_page'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$data = $request->all();
	    $page->fill($data);
	    $page->page_slug = Helper::createSlug($data['page_title']);
		$page->user_id = Auth::user()->id;
		$page->save();
		Helper::storeCustomField($this->form,$page->id, $data);
		$activity = 'Created a page';
		Activity::log($activity);

		return redirect()->back()->withSuccess(config('constants.SAVED'));		
	}

	public function update(PageRequest $request, Page $page){

		if(!Entrust::can('edit_page'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

		$data = $request->all();
		$page->fill($data);
	    $page->page_slug = Helper::createSlug($data['page_title']);
		$page->save();
		Helper::updateCustomField($this->form,$page->id, $data);
		$activity = 'Edit a page';
		Activity::log($activity);
		return redirect('/page')->withSuccess(config('constants.SAVED'));
	}

	public function destroy(Page $page){
		if(!Entrust::can('delete_page'))
			return redirect('/dashboard')->withErrors(config('constants.NA'));

        if(!Helper::getMode())
            return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		Helper::deleteCustomField($this->form, $page->id);
        $page->delete();
		$activity = 'Deleted a page';
		Activity::log($activity);

        return redirect('/page')->withSuccess(config('constants.DELETED'));
	}
}
?>