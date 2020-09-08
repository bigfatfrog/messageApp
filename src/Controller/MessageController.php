<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Services\MessageService;
use App\Services\RabbitService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class MessageController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $messageRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, MessageService $messageService,
                                RabbitService $rabbitService )
    {
        $this->entityManager = $entityManager;
        $this->messageRepository = $entityManager->getRepository('App\Entity\Message');
        $this->messageService = $messageService;
        $this->rabbitService = $rabbitService;
    }

    /**
     * @Route("/message", name="message")
     */
    public function index(Request $request)
    {

        $user  = $this->getUser();

        $form = $this->createForm(MessageType::class);

        if ($user && $request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                // perform some action...

                $text = $form->get('message')->getData();
                $phone = $form->get('phone')->getData();

                try {
                    $message = $this->messageService->createMessage($user, $phone, $text);
                } catch (\Exception $e){
                    // TODO: handle the exception
                }

                if(isset($message)){
                    $this->rabbitService->send($message->getId());
                }
            }
        }


        $messages = $this->messageRepository->findAll();

        $content = $this->render('message/index.html.twig',
            ['message_form' => $form->createView(), 'messages' => $messages, 'user' => $user]);

        return $content;
    }
}
