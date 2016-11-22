<?php

// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Nelmio\Alice\Fixtures;
use AppBundle\Entity\Genus;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
       $objects = Fixtures::load(__DIR__.'/fixtures.yml',
               $manager,
                [
                    'providers' => [$this]
                ]
            );
    }
    
    public function genus()
    {
        
          $genera = [
            'Octopus',
            'Balaena',
            'Orcinus',
            'Hippocampus',
            'Asterias',
            'Amphiprion',
            'Carcharodon',
            'Aurelia',
            'Cucumaria',
            'Balistoides',
            'Paralithodes',
            'Chelonia',
            'Trichechus',
            'Eumetopias'
          ];
        
            $key = array_rand($genera);
            
            return $genera[$key];
        
    }

    
}