<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Band;

class BandFixtures extends Fixture implements DependentFixtureInterface
{   
    public const BAND_1 = 'band-1';
    public const BAND_2 = 'band-2';

    public function load(ObjectManager $manager): void
    {
        $picture = $this->getReference(PictureFixtures::PICTURE_1);
        $picture2 = $this->getReference(PictureFixtures::PICTURE_2);
        
        $band = new Band();
        $band
            ->setName('Blackpink')
            ->setDescription('Best kpop group')
            ->setPicture($picture)
        ;
        $manager->persist($band);

        $band2 = new Band();
        $band2
            ->setName('Dreamcatcher')
            ->setDescription('Best kpop group')
            ->setPicture($picture2)
        ;
        $manager->persist($band2);

        $manager->flush();

        $this->addReference(self::BAND_1, $band);
        $this->addReference(self::BAND_2, $band2);
    }

    public function getDependencies()
    {
        return [
            PictureFixtures::class,
        ];
    }
}
