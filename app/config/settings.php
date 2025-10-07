<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\GetPraticiensAction;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepository;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\repositories\PDOPraticienRepository;
use toubilib\api\actions\GetRdvOcuppePraticienParDate;
use toubilib\core\application\ports\api\ServiceRdvInterface;
use toubilib\core\application\usecases\ServiceRdv;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepository;
use toubilib\core\application\ports\spi\repositoryInterfaces\PatientRepository;
use toubilib\infra\repositories\PDOPatientRepository;
use toubilib\infra\repositories\PDORdvRepository;
use toubilib\application_core\domain\entities\auth\AuthServiceInterface;
use toubilib\application_core\application\usecases\AuthService;
use toubilib\application_core\application\ports\spi\repositoryInterfaces\UserRepositoryInterface;
use toubilib\infrastructure\repositories\PDOUserRepository;
use toubilib\api\actions\AuthenticateUserAction;


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

    // Action Auth
    AuthenticateUserAction::class => function (ContainerInterface $c) {
        return new AuthenticateUserAction($c->get(AuthServiceInterface::class));
    },

    // service
    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepository::class));
            },

        // Action RDV
    GetRdvOcuppePraticienParDate::class => function (ContainerInterface $c) {
        return new GetRdvOcuppePraticienParDate($c->get(ServiceRdvInterface::class));
    },

    // Service RDV
    ServiceRdvInterface::class => function (ContainerInterface $c) {
        return new ServiceRdv(
            $c->get(RdvRepository::class),
            $c->get(PraticienRepository::class),
            $c->get(PatientRepository::class)
        );
    },

    // Service Auth
    AuthServiceInterface::class => function (ContainerInterface $c) {
        return new AuthService($c->get(UserRepositoryInterface::class));
    },

    // Repository RDV
    RdvRepository::class => fn(ContainerInterface $c) => new PDORdvRepository($c->get('rdv.pdo')),

    // Repository Patient
    PatientRepository::class => fn(ContainerInterface $c) => new PDOPatientRepository($c->get('patient.pdo')),

    // Repository User
    UserRepositoryInterface::class => fn(ContainerInterface $c) => new PDOUserRepository($c->get('auth.pdo')),

    PraticienRepository::class => fn(ContainerInterface $c) => new PDOPraticienRepository($c->get('praticien.pdo')),


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

    'patient.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('env.config'));
        $dsn = "{$config['pat.driver']}:host={$config['pat.host']};dbname={$config['pat.database']}";
        $user = $config['pat.username'];
        $password = $config['pat.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },

    'auth.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('env.config'));
        $dsn = "{$config['auth.driver']}:host={$config['auth.host']};dbname={$config['auth.database']}";
        $user = $config['auth.username'];
        $password = $config['auth.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },


];