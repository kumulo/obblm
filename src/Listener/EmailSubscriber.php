<?php

namespace App\Listener;

use App\Entity\Coach;
use App\Entity\EmailObjectInterface;
use App\Event\ActivateCoachEvent;
use App\Event\RegisterCoachEvent;
use App\Event\SendInvitationMessageEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailSubscriber implements EventSubscriberInterface
{
    protected $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            SendInvitationMessageEvent::NAME => 'onSendInvitationMessage',
            RegisterCoachEvent::NAME => 'onCoachRegistred',
            ActivateCoachEvent::NAME => 'onCoachActivated',
        ];
    }

    public function onSendInvitationMessage(SendInvitationMessageEvent $event) {
        $object = $event->getObject();

        if(!$object instanceof EmailObjectInterface) {
            throw new UnexpectedTypeException($object, EmailObjectInterface::class);
        }

        $championship = $event->getChampionship();
        if($object instanceof Coach) {
            $to = new Address($object->getEmail(), $object->getUsername());
        }
        else {
            $to = new Address($object->getEmail());
        }
        $email = (new TemplatedEmail())
            ->from("noreply@obblm.com") // TODO: change with env var
            ->to($to)
            ->subject('Invitation')
            ->htmlTemplate('emails/championship/invitation.html.twig')
            ->textTemplate('emails/championship/invitation.text.twig')
            ->context([
                'championship' => $championship,
            ]);
        $this->mailer->send($email);
    }
    public function onCoachRegistred(RegisterCoachEvent $event) {
        $coach = $event->getCoach();
        $address = new Address($coach->getEmail(), $coach->getUsername());
        $email = (new TemplatedEmail())
            ->from("noreply@obblm.com") // TODO: change with env var
            ->to( $address )
            ->subject('Welcome')
            ->htmlTemplate('emails/coach/register.html.twig')
            ->textTemplate('emails/coach/register.text.twig')
            ->context([
                'coach' => $coach,
            ]);
        $this->mailer->send($email);
    }
    public function onCoachActivated(ActivateCoachEvent $event) {
        $coach = $event->getCoach();
        $address = new Address($coach->getEmail(), $coach->getUsername());
        $email = (new TemplatedEmail())
            ->from("noreply@obblm.com") // TODO: change with env var
            ->to( $address )
            ->subject('Activation complete')
            ->htmlTemplate('emails/coach/activation.html.twig')
            ->textTemplate('emails/coach/activation.text.twig')
            ->context([
                'coach' => $coach,
            ]);
        $this->mailer->send($email);
    }
}