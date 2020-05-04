<?php

namespace Almanac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $table = 'attachments';

    protected $fillable = ['filename'];

    protected $appends = ['real_path'];

    public function getRealPathAttribute()
    {
        return config('almanac.file_domain') . $this->filename;
    }
}
