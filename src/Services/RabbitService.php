<?php


namespace App\Services;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Repository\StatusRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Proxies\__CG__\App\Entity\Status;
use Twilio\Rest\Client;
use DateTime;

class RabbitService
{

    private static $rabbitConnection;
    private static $twillo;
    private $queue = 'sms';
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ObjectRepository */
    private $messageRepository;

    /** @var ObjectRepository */
    private $statusRepository;

    private $predisService;

    public function __construct(EntityManagerInterface $entityManager, MessageRepository $messageRepository,
                                StatusRepository $statusRepository, PredisService $predisService)
    {

        $this->entityManager = $entityManager;
        $this->messageRepository = $messageRepository;
        $this->statusRepository = $statusRepository;
        $this->prdisService = $predisService;
    }

    public function receive($wait = true)
    {

        $connection = self::getConnection();
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";

            $message = $this->messageRepository->find($msg->body);
            if ($message) {
                $this->processMessage($message);
            }

        };

        $result = $channel->basic_consume($this->queue, '', false, true, false, false, $callback);

        while ($wait === true && $channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();

    }

    private static function getConnection()
    {
        if (!isset(self::$rabbitConnection)) {
            $host = $_ENV['RABBIT_HOST'];
            $port = $_ENV['RABBIT_PORT'];
            $user = $_ENV['RABBIT_USER'];
            $password = $_ENV['RABBIT_PASSWORD'];
            self::$rabbitConnection = new AMQPStreamConnection($host, $port, $user, $password);
        }
        return self::$rabbitConnection;
    }

    public function processMessage(Message $message)
    {
        $phone = $message->getPhone();
        $text = $message->getText();
        echo "Sending message - number: $phone text: $text";
        $twilloMessage = $this->sendSMS($phone, $text);
        $statusDesc = $twilloMessage->status;
        echo "SMS status:$statusDesc";
        $status = $this->statusRepository->findOneBy(array('description' => $statusDesc));
        if ($status) {
            $message->setStatus($status);
            $message->setUpdatedAt(new DateTime());
            $message->setSid($twilloMessage->sid);
            $this->entityManager->persist($message);
            $this->entityManager->flush();
        }
        return $message;
    }

    public function sendSMS($phone, $text)
    {

        $client = self::twilloClient();
        $number = $_ENV['TWILLO_NUMBER'];
        $message = $client->messages->create(
            $phone, // Text this number
            [
                'from' => $number, // From a valid Twilio number
                'body' => $text
            ]
        );

        return $message;
    }

    public static function twilloClient()
    {

        if (!isset(self::$twillo)) {
            $sid = $_ENV['TWILLO_SID']; // Your Account SID from www.twilio.com/console
            $token = $_ENV['TWILLO_TOKEN']; // Your Auth Token from www.twilio.com/console

            self::$twillo = new Client($sid, $token);
        }

        return self::$twillo;
    }

    public function send($text)
    {

        $connection = self::getConnection();
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, false, false, false);

        $msg = new AMQPMessage($text);
        $result = $channel->basic_publish($msg, '', $this->queue);

        $channel->close();
        $connection->close();

        return $result;
    }

    public function getSMS(Message $message)
    {
        $client = self::twilloClient();

        $twilloMessage = $client->messages($message->getSid())
            ->fetch();

        $statusDesc = $twilloMessage->status;
        $status = $this->statusRepository->findOneBy(array('description' => $statusDesc));
        if ($status) {
            $message->setStatus($status);
            $message->setUpdatedAt(new DateTime());
            $message->setSid($twilloMessage->sid);
            $this->entityManager->persist($message);
            $this->entityManager->flush();
        }
        return $message;
    }
}
