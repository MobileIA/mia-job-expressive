# MobileIA Job Expressive
Libreria para ejecutar Jobs.

1. Incluir libreria:
```bash
composer require mobileia/mia-job-expressive
```
2. Crear Jobs, ejemplo:
```php
namespace App\Job;
/**
 * Description of TestJob
 *
 * @author matiascamiletti
 */
class TestJob extends \Mobileia\Expressive\Job\Execute\ExecuteJob
{
    protected $queue = 'test-job';
    
    public function start()
    {
        // Ejecutar acción
        
        // Devolver data para guardar
        return ['testing' => true];
    }

}
```
3. Crear archivo "job.global.php" en "config/autoload":
```php
return [
    'mobileia_job' => [
        'queues'    => [
            'test-job' => TestJob::class
        ],
    ]
];
```
4. Iniciar libreria desde "index.php":
```php
/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';

// Inicializar Jobs
Mobileia\Expressive\Job\Config\Install::install($container);
```
5. Agregar handler en las rutas (config/routes.php):
```php
/** JOBS **/
$app->route('/mia-jobs/execute', [Mobileia\Expressive\Job\Handler\JobHandler::class], ['GET', 'POST'], 'mia_jobs.execute');
```
6. Ejemplo de como generar un nuevo Job:
```php
\Mobileia\Expressive\Job\Execute\ExecuteJob::addByExecutor(new \App\Job\TestJob(), array('item' => '2'));
```
7. Si no se va a utilizar Google Tasks, configurar Cron (config/routes.php):
```php
/** JOBS **/
$app->route('/mia-jobs/cron', [Mobileia\Expressive\Job\Handler\CronHandler::class], ['GET', 'POST'], 'mia_jobs.cron');
```


## Configuración Google Tasks
1. Crear queue:
```sh
gcloud tasks queues create [QUEUE_ID]
```
2. Ver datos del queue:
```sh
gcloud tasks queues describe [QUEUE_ID]
```