<?php


namespace App\Services;


use App\Entity\Message;
use App\Entity\User;
use App\Repository\StatusRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class MessageService
{

    public function __construct(EntityManagerInterface $entityManager,StatusRepository $statusRepository){

        $this->entityManager = $entityManager;
        $this->statusRepository = $statusRepository;
    }

    public function createMessage(User $user, $phone, $text){

        // check input before updating
        if(strlen($text) <= 140 && strlen($text) > 0 && self::validatePhone($phone)){
            $message = new Message();
            $message->setUser($user);
            $message->setPhone($phone);
            $message->setText($text);
            $message->setStatus($this->statusRepository->findOneBy(array('description' => 'awaiting')));
            $message->setUpdatedAt(new DateTime());
            $this->entityManager->persist($message);
            $this->entityManager->flush();

            return $message;
        } else {
            throw new \Exception("Invalid message input");
        }
    }

    private static function validatePhone($phone){
        $result = preg_match("/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/i",
        $phone);
        return $result;
    }
}
