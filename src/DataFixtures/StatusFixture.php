<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $status = new Status();
        $status->setDescription('Awaiting');
        $manager->persist($status);
        $status = new Status();
        $status->setDescription('Sent');
        $manager->persist($status);
        $status = new Status();
        $status->setDescription('Error');
        $manager->persist($status);

        $manager->flush();
    }
}
