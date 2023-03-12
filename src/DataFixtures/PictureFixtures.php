<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class PictureFixtures extends Fixture
{
    public const PICTURE_1 = 'picture-1';
    public const PICTURE_2 = 'picture-2';
    public const PICTURE_HALL = 'picture-hall';

    public function load(ObjectManager $manager): void
    {
        $picture = new Picture();
        $picture
            ->setName('blackpink.png')
        ;
        $manager->persist($picture);

        $picture2 = new Picture();
        $picture2
            ->setName('dreamcatcher.png')
        ;
        $manager->persist($picture2);

        $pictureHall = new Picture();
        $pictureHall
            ->setName('hall.png')
        ;
        $manager->persist($pictureHall);

        $manager->flush();

        $this->addReference(self::PICTURE_1, $picture);
        $this->addReference(self::PICTURE_2, $picture2);
    }
}
