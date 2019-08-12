<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SwapiClient
{
    private $httpClient;
    private $host;

    public function __construct(HttpClientInterface $httpClient, $host)
    {
        $this->httpClient = $httpClient;
        $this->host = $host;
    }

    public function getPlanetsAndResidentsData()
    {
        $planets = [];
        $planetsPage = $this->httpClient->request('GET', $this->host . '/api/planets/');

        if ($planetsPage->getStatusCode() === 200) {
            $this->getPlanets($planetsPage->toArray(), $planets);
            foreach ($planets as &$planet) {
                $planet['residents'] = $this->getResidents($planet);
            }
        }

        return $planets;
    }

    protected function getPlanets($page, &$planets)
    {
        $planets = array_merge($planets, $page['results']);

        if (!is_null($page['next'])) {
            $newPlanetsPage = $this->httpClient->request('GET', $page['next']);
            $this->getPlanets($newPlanetsPage->toArray(), $planets);
        }
    }

    protected function getResidents($planet)
    {
        $residents = [];
        foreach ($planet['residents'] as $residentUrl) {
            $residents[] = $this->httpClient->request('GET', $residentUrl)->toArray();
        }
        return $residents;
    }
}