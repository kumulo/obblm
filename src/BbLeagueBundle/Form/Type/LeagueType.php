<?php
namespace BbLeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeagueType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null)
            ->add('rule', ChoiceType::class, [
                'required' => true,
                'choices' => $options['rules']
            ])
            ->add('format', null)
            ->add('number_of_journeys', null)
            ->add('points_for_win', null)
            ->add('points_for_draw', null)
            ->add('points_for_lost', null)
            ->add('number_for_playoff', null)
            ->add('tie_break_1', ChoiceType::class, [
                'required' => true,
                'choices' => $options['available_tiebreaks'],
                'choice_translation_domain'  => 'messages',
            ])
            ->add('tie_break_2', ChoiceType::class, [
                'required' => true,
                'choices' => $options['available_tiebreaks'],
                'choice_translation_domain'  => 'messages',
            ])
            ->add('tie_break_3', ChoiceType::class, [
                'required' => true,
                'choices' => $options['available_tiebreaks'],
                'choice_translation_domain'  => 'messages',
            ])
            ->add('save', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'          => 'BbLeagueBundle\Entity\League',
            'rules'               => 'Doctrine\Common\Collections\ArrayCollection',
            'available_tiebreaks' => 'Doctrine\Common\Collections\ArrayCollection',
            'translation_domain'  => 'form'
        ]);

    }
    public function getName()
    {
        return 'obbml_forms_admin_league';
    }
}
