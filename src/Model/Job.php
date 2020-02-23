<?php namespace Mobileia\Expressive\Job\Model;

/**
 * Description of Job
 *
 * @author matiascamiletti
 */
class Job extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'jobs';
    
    protected $casts = ['payload' => 'object', 'result' => 'object'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    //public $timestamps = false;
}
