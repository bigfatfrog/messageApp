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
        $status1->setDescription('awaiting');
        $manager->persist($status1);
        $status2 = new Status();
        $status2->setDescription('sent');
        $manager->persist($status2);
        $status3 = new Status();
        $status3->setDescription('queued');
        $manager->persist($status3);
        $status = new Status();
        $status->setDescription('delivered');
        $manager->persist($status);
        $status = new Status();
        $status->setDescription('undelivered');
        $manager->persist($status);
        $status = new Status();
        $status->setDescription('failed');
        $manager->persist($status);

        $jim = new User();
        $jim->setName('Jim Bowen');
        $jim->setPassword(password_hash('password', PASSWORD_DEFAULT));
        $jim->setUsername('jim');
        $manager->persist($jim);
        $brian = new User();
        $brian->setName('Brian Giffin');
        $brian->setPassword(password_hash('password', PASSWORD_DEFAULT));
        $brian->setUsername('brian');
        $manager->persist($brian);
        $lulu = new User();
        $lulu->setName('Lulu');
        $lulu->setPassword(password_hash('password', PASSWORD_DEFAULT));
        $lulu->setUsername('lulu');
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
