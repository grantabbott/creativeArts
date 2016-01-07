<?php
namespace App;
use Eloquent;

class Annoucement extends Eloquent {

	protected $fillable = [
							'annoucement_title',
							'annoucement_description',
							'start_date',
							'end_date',
							'for_all',
							'user_id'
						];
	protected $primaryKey = 'id';
	protected $table = 'annoucements';

	public function role()
    {
        return $this->belongsToMany('App\Role','annoucement_roles','annoucement_id','role_id');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
