<?php
namespace App\Http\Controllers;
use DB;
use App\Comment;
use Auth;
use Activity;
use Config;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

Class CommentController extends Controller{

	public function store(CommentRequest $request, Comment $comment){

	    $comment->fill($request->all());
	    $comment->user_id = Auth::user()->id;
	    $comment->save();
		$activity = 'Commented on a '.ucfirst($request->input('belongs_to'));
		Activity::log($activity);
	    
	    return redirect()->back()->withSuccess(config('constants.SAVED'));
	}

	public function destroy(Comment $comment){
		if($comment->user_id != Auth::user()->id && !Entrust::hasRole('admin'))
			return redirect()->back()->withErrors(config('constants.INVALID_LINK'));

		$belongs_to = $comment->belongs_to;
		$comment->delete();
		$activity = 'Deleted a commented on a '.ucfirst($belongs_to);
		Activity::log($activity);
		return redirect()->back()->withSuccess(config('constants.DELETED'));
	}
}
?>