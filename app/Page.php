<?php
namespace App;
use Eloquent;

class Page extends Eloquent {

	protected $fillable = [
							'published',
							'page_title',
							'page_slug',
							'page_description',
							'user_id'
						];
	protected $primaryKey = 'id';
	protected $table = 'pages';

    public function user()
    {
        return $this->belongsTo('App\User'); 
    }
}
