<?php

namespace BBlm\Listener;

use BBlm\Entity\ChampionshipInvitation;
use BBlm\Entity\Coach;
use BBlm\Event\ChampionshipLaunchedEvent;
use BBlm\Event\ChampionshipUpdateEvent;
use BBlm\Event\EncounterValidatedEvent;
use BBlm\Event\RegisterCoachEvent;
use BBlm\Event\SendEncounterValidationMessageEvent;
use BBlm\Event\SendInvitationMessageEvent;
use BBlm\Service\ChampionshipFormat\ChampionshipFormatInterface;
use BBlm\Service\ChampionshipService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ChampionshipSubscriber implements EventSubscriberInterface
{
    protected $em;
    protected $dispatcher;
    protected $championshipService;

    public function __construct(EntityManagerInterface $em,
                                EventDispatcherInterface $dispatcher,
                                ChampionshipService $championshipService) {
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
            EncounterValidatedEvent::NAME => 'onEncounterValidated'
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
    }

    public function onEncounterValidated(EncounterValidatedEvent $event) {
        $encounter = $event->getEncounter();
        $validator = $event->getValidator();
        $format = $this->championshipService->getFormat($encounter->getChampionship()->getFormat());
        $format->validateEncounter($encounter);
        if($validator instanceof Coach) {
            $encounter->setValidatedBy($validator);
        }
        $this->em->persist($encounter);
        $this->em->flush();
        if($encounter->getValidatedAt() && $validator) {
            $event = new SendEncounterValidationMessageEvent($encounter);
            $this->dispatcher->dispatch($event, SendEncounterValidationMessageEvent::NAME);
        }
    }
}