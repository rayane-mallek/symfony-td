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
            ->setDate(new \DateTime('next month'))
            ->setHall($hall2)
            ->addBand($band)
        ;
        $manager->persist($concert);

        $concert2 = new Concert();
        $concert2
            ->setDate(new \DateTime('next month'))
            ->setHall($hall)
            ->addBand($band2)
        ;
        $manager->persist($concert2);

        $concert3 = new Concert();
        $concert3
            ->setDate(new \DateTime('last month'))
            ->setHall($hall2)
            ->addBand($band)
        ;
        $manager->persist($concert3);

        $concert4 = new Concert();
        $concert4
            ->setDate(new \DateTime('last month'))
            ->setHall($hall)
            ->addBand($band2)
        ;
        $manager->persist($concert4);

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
