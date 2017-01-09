<?php
namespace BbLeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use BbLeagueBundle\Services\RulesService;

class TeamStep2 extends AbstractType
{
    private $rules;
    private $translator;

    public function __construct($translator, RulesService $rules)
    {
        $this->translator = $translator;
        $this->rules = $rules;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $krule = $builder->getData()->getLeague()->getRule();
        $rule = $this->rules->getRule($krule)->getRule();

        $rosters_choice = array();
        foreach($rule['rosters'] as $kroster => $roster) {
            $rosters_choice[$kroster] = $this->translator->trans($krule . '.rosters.' . $kroster . '.title', array(), $krule);
        }
        asort($rosters_choice);
        $builder
            ->add('name', 'text', array(
                'required'    => true,
            ))
            ->add('roster', 'choice', array(
                'choices'  => $rosters_choice,
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLeagueBundle\Entity\Team',
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_user_team';
    }
}
