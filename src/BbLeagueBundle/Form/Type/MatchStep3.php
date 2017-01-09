<?php
namespace BbLeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\ORM\EntityRepository;

class MatchStep3 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('home_skills', CollectionType::class, array(
                'entry_type' => Injury::class,
                'allow_add'  => true,
            ))
            ->add('visitor_skills', CollectionType::class, array(
                'entry_type' => Injury::class,
                'allow_add'  => true,
            ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLeagueBundle\Entity\Match',
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_user_encounter_3';
    }
}
