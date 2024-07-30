<?php

namespace App\Controller\Page;

use App\Utils\ContactFormDTO;
use App\Form\ContactFormDTOType;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('pages/home.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contactFormDTO = new ContactFormDTO;

        $form = $this->createForm(ContactFormDTOType::class, $contactFormDTO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($contactFormDTO->getEmail())
                ->to(new Address('mon-site-de-recettes@example.com'))
                ->subject($contactFormDTO->getSubject())

                // path of the Twig template to render
                ->htmlTemplate('_partials/_email.html.twig')

                // change locale used in the template, e.g. to match user's locale
                ->locale('fr')

                // pass variables (name => value) to the template
                ->context([
                    'name' => $contactFormDTO->getName(),
                    'message' => $contactFormDTO->getMessage(),
                ])
            ;

            $mailer->send($email);

            $this->addFlash(type: 'info', message: 'Email envoyé, merci de nous avoir contacté');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
