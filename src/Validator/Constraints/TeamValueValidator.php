<?php

namespace App\Validator\Constraints;

use App\Entity\Team;
use App\Service\TeamService;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TeamValueValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof TeamValue) {
            throw new UnexpectedTypeException($constraint, TeamValue::class);
        }
        if (!$value instanceof Team) {
            throw new UnexpectedTypeException($value, Team::class);
        }

        $rule = $value->getChampionship() ? $value->getChampionship()->getRule() : $value->getRule();
        $limit = $rule->getMaxTeamCost() ?? TeamValue::LIMIT;
        $team_cost = TeamService::calculateTeamCost($value);

        if($team_cost > $limit) {
            $this->context->buildViolation($constraint->limitMessage)
                ->setParameter('{{ limit }}', $limit)
                ->setParameter('{{ current }}', $team_cost)
                ->addViolation();
        }
    }
}
