<?php

require_once 'lib/vendor/autoload.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

$transport = Transport::fromDsn('smtp://localhost:1025');
$mailer = new Mailer($transport);
$email = (new Email())
    ->from('test@gmail.com')
    ->to('someone@hes-so.ch')
    ->subject('Time for Symfony Mailer!')
    ->text('Sending emails is fun again!')
    ->html('<p>See Twig integration for better HTML integration!</p>');

$mailer->send($email);
