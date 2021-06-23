<?php

namespace Rafiur\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public function project_types(){
        return $this->belongsTo('Rafiur\Model\ProjectType','type_id');
    }
}
