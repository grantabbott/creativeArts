<?php
namespace App;
use Eloquent;

class BusinessHour extends Eloquent {

	protected $fillable = [
							'day',
							'start',
							'end'
						];
	protected $primaryKey = 'id';
	protected $table = 'business_hours';

}
