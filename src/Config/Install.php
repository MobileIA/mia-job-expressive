<?php namespace Mobileia\Expressive\Job\Config;

/**
 * Description of Install
 *
 * @author matiascamiletti
 */
class Install 
{
    /**
     *
     * @var array
     */
    static $QUEUES = [];
    /**
     * Inicializa la base de datos con Eloquent Lavarel
     */
    public static function install(\Psr\Container\ContainerInterface $container)
    {
        self::$QUEUES = $container->get('config')['mobileia_job']['queues'];
    }
}