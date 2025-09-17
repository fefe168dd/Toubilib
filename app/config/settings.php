<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\GetPraticiensAction;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepository;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\repositories\PDOPraticienRepository;

return [

    // settings
    'displayErrorDetails' => true,
    'logs.dir' => __DIR__ . '/../../var/logs',
    'toubilib.db.config' => __DIR__ . '/toubilib.db.ini',
    'env.config' => __DIR__ . '/.env.dist',

    // application
    GetPraticiensAction::class => function (ContainerInterface $c) {
        return new GetPraticiensAction($c->get(ServicePraticienInterface::class));
    },

    // service
    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepository::class));
    },

    // infra
    'praticien.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('env.config'));
        $dsn = "{$config['prat.driver']}:host={$config['prat.host']};dbname={$config['prat.database']}";
        $user = $config['prat.username'];
        $password = $config['prat.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },
    'rdv.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('env.config'));
        $dsn = "{$config['rdv.driver']}:host={$config['rdv.host']};dbname={$config['rdv.database']}";
        $user = $config['rdv.username'];
        $password = $config['rdv.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },


    PraticienRepository::class => fn(ContainerInterface $c) => new PDOPraticienRepository($c->get('praticien.pdo')),
    
];