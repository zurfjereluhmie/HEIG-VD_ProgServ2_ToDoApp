<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

$transport = Transport::fromDsn('smtp://host.docker.internal:1025');
$mailer = new Mailer($transport);
$email = (new Email())
    ->from('dominique.martin@heig-vd.ch')
    ->to('desti.nataire@quelquepart.com')
    ->subject('Concerne : Envoi de mail')
    ->text('Un peu de texte')
    ->html('<h1>Un peu de html</h1>');
try {
    $mailer->send($email);
    echo "Mail envoyé\n";
    echo "<a href='http://localhost:8025'>MailHog</a>";
} catch (TransportExceptionInterface $e) {
    echo $e->getMessage();
}
