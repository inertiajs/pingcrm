<?php

namespace App\Models;

use GrahamCampbell\ResultType\Result;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;
use Illuminate\Support\Facades\DB;

class Document extends Model
{
    use AsPivot {
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documents';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $with = ['files'];

    // protected $appends = [
    //     'id'
    // ];


    // public function getIdAttribute()
    // {
    //     $result =  DB::table('documents')->select('id')
    //         ->where('expedient_id', $this->expedient_id)
    //         ->where('requirement_id', $this->requirement_id)
    //         ->first();

    //     return $result->id;
    // }

    public function files()
    {
        return $this->hasMany(File::class, 'document_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }
}
