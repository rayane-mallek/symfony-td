<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Picture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use App\Entity\User;

class UserFixtures extends Fixture implements DependentFixtureInterface
{   
    public const USER_1 = 'user-1';
    public const USER_2 = 'user-2';

    protected UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {   
        $picture = $this->getReference(PictureFixtures::PICTURE_1);
        $band = $this->getReference(BandFixtures::BAND_1);
        $band2 = $this->getReference(BandFixtures::BAND_2);

        $admin = new User();
        $admin
            ->setName('Admin')
            ->setLastname('Istrateur')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $admin,
                    '123456'
                )
            )
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin@concert.fr')
            ->setPicture($picture)
            ->addBand($band)
        ;
        $manager->persist($admin);

        $user = new User();
        $user
            ->setName('Utili')
            ->setLastname('Sateur')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    '123456'
                )
            )
            ->setEmail('utilisateur@concert.fr')
            ->setPicture($picture)
            ->addBand($band)
        ;
        $manager->persist($user);

        $user2 = new User();
        $user2
            ->setName('Sateur')
            ->setLastname('2')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user2,
                    '123456'
                )
            )
            ->setEmail('sateur@concert.fr')
            ->setPicture($picture)
            ->addBand($band2)
        ;
        $manager->persist($user2);

        $user3 = new User();
        $user3
            ->setName('Util')
            ->setLastname('3')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user3,
                    '123456'
                )
            )
            ->setEmail('util@concert.fr')
            ->setPicture($picture)
            ->addBand($band2)
        ; 
        $manager->persist($user3);

        $manager->flush();

        $this->addReference(self::USER_1, $user);
        $this->addReference(self::USER_2, $user);
    }

    public function getDependencies()
    {
        return [
            PictureFixtures::class,
            BandFixtures::class,
        ];
    }
}
