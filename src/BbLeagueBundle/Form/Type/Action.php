<?php
namespace BbLeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class Action extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('player', 'entity', array(
                'class' => 'BbLeagueBundle:Player',
                'choice_label' => 'name',
                'required' => true
            ))
            ->add('pass', null)
            ->add('td', null)
            ->add('int', null)
            ->add('injury', null)
            ->add('jpv', null)
            ->add('agr', null)
            ->add('car', null)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_user_encounter_action';
    }
}
