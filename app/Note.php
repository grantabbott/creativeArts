<?php
namespace App;
use Eloquent;

class Note extends Eloquent {

	protected $fillable = [
							'note',
							'user_id',
							'unique_id',
							'belongs_to'
						];
	protected $primaryKey = 'id';
	protected $table = 'notes';

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
