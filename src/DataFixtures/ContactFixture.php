<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use \App\Entity\Contact;

class ContactFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $contact = new Contact();
        $contact->setUser('Jim Bowen');
        $contact->setPhone("12345");
        $contact->setMessage("test message");
        $contact->setStatus(1);
        $contact->setUpdatedAt(new DateTime(sprintf('-%d days', rand(1, 100))));
        $manager->persist($contact);

        $contact = new Contact();
        $contact->setUser('Brian Griffin');
        $contact->setPhone("54321");
        $contact->setMessage("test message - hello");
        $contact->setStatus(2);
        $contact->setUpdatedAt(new DateTime(sprintf('-%d days', rand(1, 100))));
        $manager->persist($contact);

        $contact = new Contact();
        $contact->setUser('Peter Griffin');
        $contact->setPhone("911");
        $contact->setMessage("test message");
        $contact->setStatus(3);
        $contact->setUpdatedAt(new DateTime(sprintf('-%d days', rand(1, 100))));
        $manager->persist($contact);

        $manager->flush();
    }
}
