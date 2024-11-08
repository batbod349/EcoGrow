<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class IndexTestController extends AbstractController
{

    #[Route('/index/test', name: 'app_index_test')]
    public function index(MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $email = (new Email())
            ->from('michel@braquemard.fr')
            ->to('nathael.stalder@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);
        return $this->render('index_test/index.html.twig', [
            'reponse' => 'IndexTestController',
            'userID' => $userId,
        ]);
    }
}