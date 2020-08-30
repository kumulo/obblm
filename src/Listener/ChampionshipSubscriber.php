<?php

namespace App\Listener;

use App\Entity\ChampionshipInvitation;
use App\Entity\Coach;
use App\Event\ActivateCoachEvent;
use App\Event\ChampionshipLaunchedEvent;
use App\Event\ChampionshipUpdateEvent;
use App\Event\RegisterCoachEvent;
use App\Event\SendInvitationMessageEvent;
use App\Service\ChampionshipFormat\ChampionshipFormatInterface;
use App\Service\ChampionshipService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\VarDumper\VarDumper;

class ChampionshipSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $dispatcher;
    protected $championshipService;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher, ChampionshipService $championshipService) {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->championshipService = $championshipService;
    }

    public static function getSubscribedEvents()
    {
        return [
            ChampionshipUpdateEvent::NAME => 'onChampionshipUpdate',
            RegisterCoachEvent::NAME => 'onCoachRegistred',
            ChampionshipLaunchedEvent::NAME => 'onChampionshipLaunch',
        ];
    }

    public function onChampionshipUpdate(ChampionshipUpdateEvent $event)
    {
        $championship = $event->getChampionship();
        $coachRepository = $this->em->getRepository(Coach::class);
        // Attach existing account as guest coaches
        foreach($championship->getInvitations() as $invitation) {
            if($coach = $coachRepository->findOneBy(['email' => $invitation->getEmail()])) {
                /** @var Coach $coach */
                $championship->addGuest($coach);
                $championship->removeInvitation($invitation);
                $event = new SendInvitationMessageEvent($coach, $championship);
                $this->dispatcher->dispatch($event, SendInvitationMessageEvent::NAME);
            }
            else if(!$invitation->getHash()) {
                $toHash = $championship->getId() . "-" . $invitation->getEmail();
                $hash = hash('sha256', $toHash);
                $invitation->setHash($hash);
                $event = new SendInvitationMessageEvent($invitation, $championship);
                $this->dispatcher->dispatch($event, SendInvitationMessageEvent::NAME);
            }
        }
        $this->em->persist($championship);
        $this->em->flush();
    }

    public function onCoachRegistred(RegisterCoachEvent $event) {
        $coach = $event->getCoach();
        /** @var ChampionshipInvitation[] $invitations */
        $invitations = $this->em->getRepository(ChampionshipInvitation::class)
            ->findByEmail($coach->getEmail());
        foreach($invitations as $invitation) {
            $championship = $invitation->getChampionship();
            $championship->addGuest($coach);
            $championship->removeInvitation($invitation);
            $this->em->persist($championship);
        }

        $this->em->flush();
    }

    public function onChampionshipLaunch(ChampionshipLaunchedEvent $event) {
        $championship = $event->getChampionship();

        /** @var ChampionshipFormatInterface $format */
        $format = $this->championshipService->getFormat($championship->getFormat());

        $format->onLaunched($championship);

        VarDumper::dump($format);
        exit;
    }
}