<?php namespace Mobileia\Expressive\Job\Handler;

use \Illuminate\Database\Capsule\Manager as DB;
/**
 * Description of JobHandler
 *
 * @author matiascamiletti
 */
class JobHandler extends \Mobileia\Expressive\Request\MiaRequestHandler
{
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Obtener ID de Job a ejecutar
        $jobId = $this->getParam($request, 'id', 0);
        // Buscamos Job en la DB
        $job = \Mobileia\Expressive\Job\Model\Job::find($jobId);
        // Verificamos si existe o si ya fue ejecutado
        if($job === null||$job->status == \Mobileia\Expressive\Job\Model\Job::STATUS_EXECUTED){
            return new \Mobileia\Expressive\Diactoros\MiaJsonResponse(false);
        }
        // Verificar si el queue esta configurado
        if(!array_key_exists($job->queue, \Mobileia\Expressive\Job\Config\Install::$QUEUES)){
            return new \Mobileia\Expressive\Diactoros\MiaJsonResponse(false);
        }
        // Obtenemos la clase a ejecutar
        $className = \Mobileia\Expressive\Job\Config\Install::$QUEUES[$job->queue];
        // Creamos el objeto
        /* @var $obj \Mobileia\Expressive\Job\Execute\ExecuteJob */
        $obj = new $className();
        $obj->setJob($job);
        // Ejecutar job
        try {
            $result = $obj->start();
        } catch (\Exception $exc) {
            $job->result = $exc;
            $job->attempts++;
            $job->executed_at = DB::raw('NOW()');
            $job->save();
            
            return new \Mobileia\Expressive\Diactoros\MiaJsonResponse(false);
        }
        // Guardamos resultado
        $job->result = $result;
        $job->status = \Mobileia\Expressive\Job\Model\Job::STATUS_EXECUTED;
        $job->executed_at = DB::raw('NOW()');
        $job->save();
        // Devolvemos datos del usuario
        return new \Mobileia\Expressive\Diactoros\MiaJsonResponse(true);
    }
}