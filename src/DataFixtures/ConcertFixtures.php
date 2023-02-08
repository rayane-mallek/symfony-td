<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Concert;
use App\Entity\Hall;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    public const CONCERT_1 = 'concert-1';
    public const CONCERT_2 = 'concert-2';

    public function load(ObjectManager $manager): void
    {
        $hall = $this->getReference(HallFixtures::HALL_1);
        $hall2 = $this->getReference(HallFixtures::HALL_2);
        $band = $this->getReference(BandFixtures::BAND_1);
        $band2 = $this->getReference(BandFixtures::BAND_2);

        $concert = new Concert();
        $concert
            ->setDate(new \DateTime())
            ->setHall($hall2)
            ->addBand($band)
        ;
        $manager->persist($concert);

        $concert2 = new Concert();
        $concert2
            ->setDate(new \DateTime())
            ->setHall($hall)
            ->addBand($band2)
        ;
        $manager->persist($concert2);

        $manager->flush();

        $this->addReference(self::CONCERT_1, $concert);
        $this->addReference(self::CONCERT_2, $concert2);
    }

    public function getDependencies()
    {
        return [
            HallFixtures::class,
            BandFixtures::class
        ];
    }
}
