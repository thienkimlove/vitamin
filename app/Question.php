<?php namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Question extends Model implements SluggableInterface {

    use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
        'unique'          => true,
        'on_update'       => true,
    );

    protected $fillable = [
        'title',
        'question', 
        'seo_title',
        'desc',
        'keywords',
        'answer', 
        'slug',
        'answer_person',
        'ask_person',
        'ask_phone',
        'ask_email',
        'ask_address',
        'image',
        'status'
    ];

    protected $dates = ['created_at', 'updated_at'];


    public function scopePublish($query)
    {
        $query->where('status', true);
    }

}
