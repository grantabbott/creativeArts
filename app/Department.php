<?php
namespace App;
use Eloquent;

class Department extends Eloquent {

	protected $fillable = [
							'department_name'
						];
	protected $primaryKey = 'id';
	protected $table = 'departments';

	public function profile() {
    	return $this->hasMany('App\Profile');
	}

	public function ticket() {
    	return $this->hasMany('App\Ticket');
	}
}
