<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
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
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->messageRepository = $entityManager->getRepository('App\Entity\Message');
    }

    /**
     * @Route("/message", name="message")
     */
    public function index(Request $request)
    {


        $form = $this->createForm(MessageType::class);

        if ($request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                // perform some action...

                $message = $form->get('message')->getData();
                $phone = $form->get('phone')->getData();

                $message = new Message();
                $message->setUser('Peter Griffin');
                $message->setPhone($phone);
                $message->setText($message);
                $message->setStatus(3);
                $message->setUpdatedAt(new DateTime());
                $this->entityManager->persist($message);
                $this->entityManager->flush();

            }
        }

        $messages = $this->messageRepository->findAll();

        return $this->render('message/index.html.twig', ['message_form' => $form->createView(), 'messages' => $messages]);
    }
}
