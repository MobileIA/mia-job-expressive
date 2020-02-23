<?php

namespace Mobileia\Expressive\Job\Handler;

/**
 * Description of CronHandler
 *
 * @author matiascamiletti
 */
class CronHandler extends \Mobileia\Expressive\Request\MiaRequestHandler
{
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Obtenemos todos los Jobs que no se ejecutaron
        $jobs = \Mobileia\Expressive\Job\Model\Job::where('status', \Mobileia\Expressive\Job\Model\Job::STATUS_PENDING)->get();
        // Recorremos los Jobs
        foreach($jobs as $job){
            JobHandler::execute($job);
        }
        // Devolvemos datos del usuario
        return new \Mobileia\Expressive\Diactoros\MiaJsonResponse(true);
    }
}