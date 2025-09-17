<?php
declare(strict_types=1);



use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


return function( \Slim\App $app):\Slim\App {



    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Bienvenue sur l'API Toubilib !<br>");
        /*faire un lien vers /praticiens */
        $response->getBody()->write("<a href=\"/praticiens\">Liste des praticiens</a> <br>");
        /*faire un lien vers /praticiens/{id} avec un id exemple */
        $response->getBody()->write("<a href=\"/praticiens/af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b\">Praticien avec id af7bb2f1-cc52-3388-b9bc-c0b89e7f4c5b</a> <br>");
        return $response;
    });
    $app->get('/praticiens', \toubilib\api\actions\GetPraticiensAction::class);
    $app->get('/praticiens/{id}', \toubilib\api\actions\GetPraticienByIdAction::class);
    $app->options('/{routes:.+}', function (Request $request, Response $response) {
        return $response;
    });

    return $app;
};