<?php

namespace BbLeagueBundle\Form;

use BbLeagueBundle\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use BbLeagueBundle\Form\Type\PlayerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditTeam extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Team::class,
            'translation_domain' => 'form'
        ));

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('logo', FileType::class, array('data_class' => null))
            ->add('players', CollectionType::class, array(
                'entry_type'   => PlayerType::class,
                'by_reference' => true,
                'label_format' => '%name%'
            ))
            ->add('save', SubmitType::class, array('label' => 'Edit'))
        ;
    }
}

?>
