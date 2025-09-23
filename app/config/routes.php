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
        $response->getBody()->write("<a href=\"/rdv/occupe?debut=2025-12-05 11:00:00&fin=2025-12-05 23:00:00&praticien_id=4b1f7ae9-f6d4-3dc2-9869-45b1f2849c49\">RDV occupés du praticien</a> <br>");
        $response->getBody()->write("<a href=\"/rdv/1\">Consulter le rendez-vous avec id 1</a> <br>");
        

        return $response;
    });
    $app->get('/praticiens', \toubilib\api\actions\GetPraticiensAction::class);
    $app->get('/praticiens/{id}', \toubilib\api\actions\GetPraticienByIdAction::class);
    $app->get('/rdv/occupe', \toubilib\api\actions\GetRdvOcuppePraticienParDate::class);
    $app->get('/rdv/{id}', \toubilib\api\actions\GetRendezVousByIdAction::class);

    $app->options('/{routes:.+}', function (Request $request, Response $response) {
        return $response;
    });

    return $app;
};