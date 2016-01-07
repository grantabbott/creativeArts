<?php
namespace App;
use Eloquent;

class TicketResponse extends Eloquent {

	protected $fillable = [
							'ticket_id',
							'user_id',
							'response_description',
							'set_response_time',
							'set_resolution_time'
						];
	protected $primaryKey = 'id';
	protected $table = 'ticket_responses';

    public function ticket()
    {
        return $this->belongsTo('App\Ticket'); 
    }

    public function user()
    {
        return $this->belongsTo('App\User'); 
    }
}
