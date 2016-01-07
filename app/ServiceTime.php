<?php
namespace App;
use Eloquent;

class ServiceTime extends Eloquent {

	protected $fillable = [
							'priority',
							'response_time',
							'response_unit',
							'response_time_type',
							'resolution_time',
							'resolution_unit',
							'resolution_time_type'
						];
	protected $primaryKey = 'id';
	protected $table = 'service_times';

}
