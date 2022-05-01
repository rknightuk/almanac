<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $table = 'attachments';

    protected $fillable = ['filename'];

    public function getRealPathAttribute()
    {
        return config('almanac.file_domain') . $this->filename;
    }
}
