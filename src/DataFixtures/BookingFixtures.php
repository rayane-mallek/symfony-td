<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Concert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {   
        $user = $this->getReference(UserFixtures::USER_1);
        $user2 = $this->getReference(UserFixtures::USER_2);
        $concert = $this->getReference(ConcertFixtures::CONCERT_1);
        $concert2 = $this->getReference(ConcertFixtures::CONCERT_2);

        $booking = new Booking();
        $booking
            ->setConcert($concert)
            ->setUser($user)
            ->setDate(new \DateTime())
        ;
        $manager->persist($booking);

        $booking2 = new Booking();
        $booking2
            ->setConcert($concert)
            ->setUser($user)
            ->setDate(new \DateTime())
        ;
        $manager->persist($booking2);

        $booking3 = new Booking();
        $booking3
            ->setConcert($concert2)
            ->setUser($user2)
            ->setDate(new \DateTime())
        ;
        $manager->persist($booking3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ConcertFixtures::class
        ];
    }
}
