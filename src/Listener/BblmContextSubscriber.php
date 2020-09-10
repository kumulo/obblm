<?php

namespace BBlm\Listener;

use BBlm\Entity\Championship;
use BBlm\Entity\Team;
use BBlm\Service\BblmContextualizer;
use BBlm\Service\RuleService;
use BBlm\Service\TeamService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BblmContextSubscriber implements EventSubscriberInterface
{
    protected $context;
    protected $ruleService;

    public function __construct(BblmContextualizer $context, RuleService $ruleService) {
        $this->context = $context;
        $this->ruleService = $ruleService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => 'onFinishRequest'
        ];
    }

    public function onFinishRequest(ControllerArgumentsEvent $event) {
        $request = $event->getRequest();
        $rule_set = false;
        if($championship = $request->get('championship')) {
            if($championship instanceof Championship) {
                $this->context->setChampionship($championship);
                $this->context->setRule($this->ruleService->getRule($championship->getRule()));
                $rule_set = true;
            }
        }
        if($team = $request->get('team')) {
            if($team instanceof Team) {
                $this->context->setTeam($team);
                if(!$rule_set) {
                    $this->context->setRule($this->ruleService->getRule(TeamService::getTeamRule($team)));
                }
            }
        }
    }
}