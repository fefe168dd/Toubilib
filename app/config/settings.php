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

    // application
    GetPraticiensAction::class => function (ContainerInterface $c) {
        return new GetPraticiensAction($c->get(ServicePraticienInterface::class));
    },

    // service
    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepository::class));
    },

    // infra
    'toubilib.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('toubilib.db.config'));
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        if (!empty($config['port'])) {
            $dsn .= ";port={$config['port']}";
        }
        $user = $config['username'];
        $password = $config['password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },

    PraticienRepository::class => fn(ContainerInterface $c) => new PDOPraticienRepository($c->get('toubilib.pdo')),
];