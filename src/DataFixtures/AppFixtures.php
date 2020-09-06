<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\Status;
use App\Entity\User;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $status1 = new Status();
        $status1->setDescription('Awaiting');
        $manager->persist($status1);
        $status2 = new Status();
        $status2->setDescription('Sent');
        $manager->persist($status2);
        $status3 = new Status();
        $status3->setDescription('Error');
        $manager->persist($status3);

        $jim = new User();
        $jim->setName('Jim Bowen');
        $jim->setPassword(base64_encode('password'));
        $manager->persist($jim);
        $brian = new User();
        $brian->setName('Brian Giffin');
        $brian->setPassword(base64_encode('password'));
        $manager->persist($brian);
        $lulu = new User();
        $lulu->setName('Lulu');
        $lulu->setPassword(base64_encode('password'));
        $manager->persist($lulu);

        $manager->flush();

        $message = new Message();
        $message->setUser($brian);
        $message->setPhone("12345");
        $message->setText("test message");
        $message->setStatus($status1);
        $message->setUpdatedAt(new DateTime(sprintf('-%d days', rand(1, 100))));
        $manager->persist($message);

        $message = new message();
        $message->setUser($jim);
        $message->setPhone("54321");
        $message->setText("test message - hello");
        $message->setStatus($status2);
        $message->setUpdatedAt(new DateTime(sprintf('-%d days', rand(1, 100))));
        $manager->persist($message);

        $message = new message();
        $message->setUser($lulu);
        $message->setPhone("911");
        $message->setText("test message");
        $message->setStatus($status3);
        $message->setUpdatedAt(new DateTime(sprintf('-%d days', rand(1, 100))));
        $manager->persist($message);

        $manager->flush();
    }
}
