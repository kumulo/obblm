<?php

namespace BBlm\Event;

use BBlm\Entity\Championship;
use BBlm\Entity\EmailObjectInterface;
use Symfony\Contracts\EventDispatcher\Event;

class SendInvitationMessageEvent extends Event {
    public const NAME = 'invitation.send';

    protected $object;
    protected $championship;

    /**
     * SendInvitationMessageEvent constructor.
     * @param $object EmailObjectInterface
     * @param $championship Championship
     */
    public function __construct(EmailObjectInterface $object, Championship $championship)
    {
        $this->object = $object;
        $this->championship = $championship;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getChampionship()
    {
        return $this->championship;
    }
}