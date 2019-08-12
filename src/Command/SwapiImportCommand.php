<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\SwapiClient;
use App\Entity\Planet;
use App\Entity\People;


class SwapiImportCommand extends Command
{
    protected static $defaultName = 'app:swapi-import';

    private $swapiClient;
    private $em;

    public function __construct(SwapiClient $swapiClient, EntityManagerInterface $em)
    {
        $this->swapiClient = $swapiClient;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Import swapi.co data into database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Import started, standby time 30-60 sec, please wait...',
            '====================================================',
            '',
        ]);

        $planets = $this->swapiClient->getPlanetsAndResidentsData();

        foreach ($planets as $planet) {
            $planetDto = new Planet();
            $planetDto->setName($planet['name']);
            $planetDto->setRotationPeriod((int)$planet['rotation_period']);
            $planetDto->setOrbitalPeriod((int)$planet['orbital_period']);
            $planetDto->setDiameter((int)$planet['diameter']);
            $planetDto->setClimate($planet['climate']);
            $planetDto->setGravity($planet['gravity']);
            $planetDto->setTerrain($planet['terrain']);
            $planetDto->setSurfaceWater((int)$planet['surface_water']);
            $planetDto->setPopulation((int)$planet['population']);

            foreach ($planet['residents'] as $resident) {
                $peopleDto = new People();
                $peopleDto->setName($resident['name']);
                $peopleDto->setHeight($resident['height']);
                $peopleDto->setMass((int)$resident['mass']);
                $peopleDto->setHairColor($resident['hair_color']);
                $peopleDto->setSkinColor($resident['skin_color']);
                $peopleDto->setEyeColor($resident['eye_color']);
                $peopleDto->setBirthYear($resident['birth_year']);
                $peopleDto->setGender($resident['gender']);

                $planetDto->addPerson($peopleDto);
            }
            $this->em->persist($planetDto);
            $this->em->flush();
        }

        $output->writeln('Done!');
    }
}
