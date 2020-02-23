<?php namespace Mobileia\Expressive\Job\Execute;

/**
 * Description of ExecuteJob
 *
 * @author matiascamiletti
 */
abstract class ExecuteJob 
{
    /**
     *
     * @var \Mobileia\Expressive\Job\Model\Job
     */
    protected $job;
    /**
     *
     * @var string
     */
    protected $queue = '';
    
    abstract public function start();
    /**
     * 
     * @param \Mobileia\Expressive\Job\Model\Job $item
     */
    public function setJob($item)
    {
        $this->job = $item;
    }
    public function getQueue()
    {
        return $this->queue;
    }
    
    public static function addByExecutor(ExecuteJob $executor, $payload)
    {
        self::addByQueueName($executor->getQueue(), $payload);
    }
    
    public static function addByQueueName(string $queue, $payload)
    {
        $job = new \Mobileia\Expressive\Job\Model\Job();
        $job->queue = $queue;
        $job->payload = $payload;
        $job->status = \Mobileia\Expressive\Job\Model\Job::STATUS_PENDING;
        $job->save();
    }
}