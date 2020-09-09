<?php


namespace App\Services;


use App\Entity\Message;
use App\Entity\User;
use App\Repository\StatusRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MessageService
{

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ObjectRepository */
    private $statusRepository;

    private $predisService;

    public function __construct(EntityManagerInterface $entityManager,
                                StatusRepository $statusRepository,
                                PredisService $predisService)
    {

        $this->entityManager = $entityManager;
        $this->statusRepository = $statusRepository;
        $this->predisService = $predisService;
    }

    public function createMessage(User $user, $phone, $text)
    {

        $datetime = new DateTime();

        $lastDatetime = $this->predisService->get("user_" . $user->getId());
        $diff = strtotime($datetime->format('Y-m-d H:i:s')) - strtotime($lastDatetime);
        if ($diff <= 15) {
            throw new Exception("Messages within 15 secs");
        } // check input before updating
        else if (strlen($text) <= 140 && strlen($text) > 0 && self::validatePhone($phone)) {

            $message = new Message();
            $message->setUser($user);
            $message->setPhone($phone);
            $message->setText($text);
            $message->setStatus($this->statusRepository->findOneBy(array('description' => 'awaiting')));
            $message->setUpdatedAt($datetime);
            $this->entityManager->persist($message);
            $this->entityManager->flush();
            $this->predisService->set("user_" . $user->getId(), $datetime->format('Y-m-d H:i:s'));
            return $message;

        } else {
            throw new Exception("Invalid message input");
        }
    }

    private static function validatePhone($phone)
    {
        $result = preg_match("/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/i",
            $phone);
        return $result;
    }
}
