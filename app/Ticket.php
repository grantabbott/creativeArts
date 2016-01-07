<?php
namespace App;
use Eloquent;

class Ticket extends Eloquent {

	protected $fillable = [
							'ticket_no',
							'ticket_subject',
							'ticket_description',
							'ticket_status',
							'ticket_priority',
							'ticket_type_id',
							'department_id',
							'user_id',
							'response_due_time',
							'resolution_due_time'
						];
	protected $primaryKey = 'id';
	protected $table = 'tickets';

    public function ticketType()
    {
        return $this->belongsTo('App\TicketType'); 
    }

    public function user()
    {
        return $this->belongsTo('App\User'); 
    }

	public function assignedUser()
    {
        return $this->belongsToMany('App\User','assigned_tickets','ticket_id','user_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department'); 
    }

    public function ticketResponse()
    {
        return $this->hasMany('App\TicketResponse'); 
    }
}
