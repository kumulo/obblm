<?php
namespace BbLeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class League extends AbstractType
{
    private $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $rules = $this->provider->getRulesForForm();
        $builder
            ->add('name', null)
            ->add('rule', 'choice', array(
                'required' => true,
                'choices' => $rules
            ))
            ->add('format', null)
            ->add('number_of_journeys', null)
            ->add('points_for_win', null)
            ->add('points_for_draw', null)
            ->add('points_for_lost', null)
            ->add('number_for_playoff', null)
            ->add('save', 'submit')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLeagueBundle\Entity\League',
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_admin_league';
    }
}
