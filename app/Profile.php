<?php
namespace App;
use Eloquent;

class Profile extends Eloquent {

	protected $fillable = [
							'department_id',
							'photo',
							'user_id',
							'contact_number',
							'alternate_contact_number',
							'alternate_email',
							'address',
							'timezone_id'
						];
	protected $primaryKey = 'id';
	protected $table = 'profile';

	public function user() {
    	return $this->belongsTo('App\User');
	}

	public function department() {
    	return $this->belongsTo('App\Department');
	}
}
