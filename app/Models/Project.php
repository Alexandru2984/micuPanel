<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function tags() { return $this->belongsToMany(Tag::class); }
    public function domains() { return $this->hasMany(Domain::class); }
    public function repositories() { return $this->hasMany(Repository::class); }
    public function services() { return $this->hasMany(Service::class); }
    public function notes() { return $this->hasMany(Note::class); }
    public function quickLinks() { return $this->hasMany(QuickLink::class); }
}
