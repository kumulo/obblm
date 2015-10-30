<?php

namespace BbLigueBundle\Twig;

class BbLigueTwigExtension extends \Twig_Extension
{
    private $translator;

    public function __construct($translator) {
       $this->translator = $translator;
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('injuries', array($this, 'injuriesFilter')),
            new \Twig_SimpleFilter('skills', array($this, 'skillsFilter')),
            new \Twig_SimpleFilter('bbprice', array($this, 'bbPriceFilter')),
        );
    }

    public function injuriesFilter($injuries, $separator = ', ', $full_text = false, $forcelang = false)
    {
        $a = array();
        foreach($injuries as $injury) {
            $txt = $this->translator->trans('blood_bowl.injuries_abbr.' . $injury, array(), 'bb-dictionnary', $forcelang);
            $a[] = ($full_text) ? $txt : '<span title="' . $txt . '">' . $injury . '</span>';
        }
        return join($separator, $a);
    }

    public function skillsFilter($skills, $separator = ', ', $with_desc = false, $forcelang = false)
    {
        $a = array();

        foreach($skills as $skill) {
            $title = $this->translator->trans('blood_bowl.skills.' . $skill . '.title', array(), 'bb-dictionnary', $forcelang);
            $desc = $this->translator->trans('blood_bowl.skills.' . $skill . '.description', array(), 'bb-dictionnary', $forcelang);
            $a[] = ($with_desc) ? '<span title="' . htmlentities( $desc ) . '">' . $title . '</span>' : $title;
        }

        return join($separator, $a);
    }

    public function bbPriceFilter($number, $comma = '.', $separator = ',')
    {
        return number_format($number, 0, $separator, $comma);
    }

    public function getName()
    {
        return 'bbligue_extension';
    }
}
