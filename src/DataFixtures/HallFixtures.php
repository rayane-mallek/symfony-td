<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hall;
use App\Entity\Picture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class HallFixtures extends Fixture implements DependentFixtureInterface
{
    public const HALL_1 = 'hall-1';
    public const HALL_2 = 'hall-2';
    public const HALL_3 = 'hall-3';

    public function load(ObjectManager $manager): void
    {   
        $picture = $this->getReference(PictureFixtures::PICTURE_1);
        
        $hall = new Hall();
        $hall 
            ->setName('Salle 1')
            ->setCapacity(100)
            ->setPicture($picture)
        ;
        $manager->persist($hall);

        $hall2 = new Hall();
        $hall2 
            ->setName('Salle 2')
            ->setCapacity(1000)
            ->setPicture($picture)
        ;
        $manager->persist($hall2);

        $hall3 = new Hall();
        $hall3 
            ->setName('Salle 3')
            ->setCapacity(10000)
            ->setPicture($picture)
        ;
        $manager->persist($hall3);

        $manager->flush();

        $this->addReference(self::HALL_1, $hall);
        $this->addReference(self::HALL_2, $hall2);
        $this->addReference(self::HALL_3, $hall3);
    }

    public function getDependencies()
    {
        return [
            PictureFixtures::class,
        ];
    }
}
