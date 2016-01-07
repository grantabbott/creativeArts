<?php
namespace App;
use Eloquent;

class Attachment extends Eloquent {

	protected $fillable = [
							'file_title',
							'file_description',
							'unique_id',
							'belongs_to',
							'user_id',
							'file'
						];
	protected $primaryKey = 'id';
	protected $table = 'attachments';

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
