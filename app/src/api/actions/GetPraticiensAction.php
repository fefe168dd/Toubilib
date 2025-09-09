<?php

namespace App\Api\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\infra\repositories\PDOPraticienRepository;

class GetPraticiensAction
{
    private PDOPraticienRepository $repository;

    public function __construct(PDOPraticienRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $praticiens = $this->repository->listerPraticiens();
        $payload = json_encode($praticiens);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}