<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    private $contactRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->contactRepository = $entityManager->getRepository('App\Entity\Contact');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {


        $form = $this->createForm(ContactType::class);

        if ($request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                // perform some action...

                $message = $form->get('message')->getData();
                $phone = $form->get('phone')->getData();

                $contact = new Contact();
                $contact->setUser('Peter Griffin');
                $contact->setPhone($phone);
                $contact->setMessage($message);
                $contact->setStatus(3);
                $contact->setUpdatedAt(new DateTime());
                $this->entityManager->persist($contact);
                $this->entityManager->flush();

            }
        }

        $contacts = $this->contactRepository->findAll();
       var_dump($contacts);
        return $this->render('contact/index.html.twig', ['contact_form' => $form->createView(), 'contacts' => $contacts]);
    }
}
