<?php
namespace BbLeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class Encounter extends AbstractType
{
    private $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $rules = $this->provider->getRulesForForm();
        $journey = $builder->getData()->getJourney();
        $team = $builder->getData()->getTeam();
        $builder
            ->add('weather', null)
            ->add('home_actions', CollectionType::class, array(
                'entry_type' => Action::class,
                'allow_add'  => true,
                'delete_empty'  => true,
            ))
            ->add('home_injuries', CollectionType::class, array(
                'entry_type' => Injury::class,
                'allow_add'  => true,
                'delete_empty'  => true,
            ))
            ->add('visitor_actions', CollectionType::class, array(
                'entry_type' => Action::class,
                'allow_add'  => true,
                'delete_empty'  => true,
            ))
            ->add('visitor_injuries', CollectionType::class, array(
                'entry_type' => Injury::class,
                'allow_add'  => true,
                'delete_empty'  => true,
            ))
            ->add('home_skills', CollectionType::class, array(
                'entry_type' => Injury::class,
                'allow_add'  => true,
                'delete_empty'  => true,
            ))
            ->add('visitor_skills', CollectionType::class, array(
                'entry_type' => Injury::class,
                'allow_add'  => true,
                'delete_empty'  => true,
            ))
            ->add('save', 'submit')
        ;
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
        return 'obbml_forms_user_encounter';
    }
}
