<?php 
namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\core\application\ports\api\ServiceRdvInterface;
use DateTime;
use toubilib\core\application\ports\api\dto\RdvDTO;

class GetRdvOcuppePraticienParDate
{
    private ServiceRdvInterface $service;

    public function __construct(ServiceRdvInterface $service)
    {
        $this->service = $service;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $params = $request->getQueryParams();
        $debut = new DateTime($params['debut']);
        $fin = new DateTime($params['fin']);
        $praticien_id = $params['praticien_id'];

        $rdvs = $this->service->listerRdvOcuppePraticienParDate($debut, $fin, $praticien_id);
        $rdvDTOs = array_map(fn($rdv) => new RdvDTO($rdv), $rdvs);
        $payload = json_encode($rdvDTOs);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}