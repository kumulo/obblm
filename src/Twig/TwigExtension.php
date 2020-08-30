<?php

namespace App\Twig;

use App\Entity\Player;
use App\Entity\Team;
use App\Service\PlayerService;
use App\Service\TeamService;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension {

    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
            new TwigFilter('yesno', [$this, 'formatBooleanToString']),
        ];
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('area', [$this, 'calculateArea']),
        ];
    }

    public function calculateArea(int $width, int $length)
    {
        return $width * $length;
    }

    public function formatPrice($number, $decimals = 0, $decPoint = '.', $thousandsSep = ','):string
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);

        return $price;
    }
    public function formatBooleanToString(bool $var):string {
        return ($var) ? 'yes' : 'no';
    }
}