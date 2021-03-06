<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpisodeLink extends Model
{
    protected $table = 'episode_links';
    protected $fillable = ['link', 'episode_id'];
    public $timestamp = true;

    public function episode() {
        return $this->belongsTo('App\Episode');
    }
}
