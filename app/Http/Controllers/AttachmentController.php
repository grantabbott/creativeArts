<?php
namespace App\Http\Controllers;
use App\Classes\Helper;
use Config;
use App\Attachment;
use File;
use Activity;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AttachmentRequest;

Class AttachmentController extends Controller{

	public function store(AttachmentRequest $request, Attachment $attachment){

		if(!Helper::getMode())
			return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		$filename = uniqid();

	     $data = $request->all();

     	if ($request->hasFile('file')) {
	 		$extension = $request->file('file')->getClientOriginalExtension();
	 		$file = $request->file('file')->move('uploads/attachment_files/', $filename.".".$extension);
	 		$data['file'] = $filename.".".$extension;
		 }
		 
		$data['user_id'] = Auth::user()->id;
		$attachment->fill($data);

		$attachment->save();

		$activity = 'Attached a file on a '.$request->input('belongs_to');
		Activity::log($activity);

		return redirect()->back()->withSuccess(config('constants.SAVED'));
	}

	public function destroy(Attachment $attachment){
		if(!Helper::getMode())
			return redirect()->back()->withErrors(config('constants.DISABLE_MESSAGE'));

		if($attachment->user_id != Auth::user()->id && !Entrust::hasRole('admin'))
			return redirect()->back()->withErrors(config('constants.INVALID_LINK'));

		$belongs_to = $attachment->belongs_to;
		File::delete('uploads/attachment_files/'.$attachment->file);
		$attachment->delete($id);

		$activity = 'Deleted a file on a '.$belongs_to;
		Activity::log($activity);
		return redirect()->back()->withSuccess(config('constants.DELETED'));
	}
}
?>