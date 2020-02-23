<?php namespace Mobileia\Expressive\Job\Model;

/**
 * Description of Job
 *
 * @author matiascamiletti
 */
class Job extends \Illuminate\Database\Eloquent\Model
{
    const STATUS_PENDING = 0;
    const STATUS_EXECUTED = 1;
    
    protected $table = 'mia_jobs';
    
    protected $casts = ['payload' => 'object', 'result' => 'object'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    //public $timestamps = false;
}
