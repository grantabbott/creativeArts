<?php
namespace App;
use Eloquent;

class TicketType extends Eloquent {

	protected $fillable = [
							'ticket_type_name'
						];
	protected $primaryKey = 'id';
	protected $table = 'ticket_types';

    public function ticket()
    {
        return $this->hasMany('App\Ticket'); 
    }
}
