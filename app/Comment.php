<?php
namespace App;
use Eloquent;

class Comment extends Eloquent {

	protected $fillable = [
							'user_id',
							'unique_id',
							'belongs_to',
							'comment'
						];
	protected $primaryKey = 'id';
	protected $table = 'comments';

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
