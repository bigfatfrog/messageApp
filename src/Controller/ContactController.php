<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
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
                $em = $this->getDoctrine()->getManager();
                $message = $form->get('message')->getData();
                $phone = $form->get('phone')->getData();

                $contact = new Contact();
                $contact->setUser('Peter Griffin');
                $contact->setPhone($phone);
                $contact->setMessage($message);
                $contact->setStatus(3);
                $contact->setUpdatedAt(new DateTime(sprintf('-%d days', rand(1, 100))));
                $em->persist($contact);

                $em->flush();

            }
        }

        return $this->render('contact/index.html.twig', ['contact_form' => $form->createView(),]);
    }
}
