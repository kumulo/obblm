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
        $builder
            ->add('weather', null)
            ->add('home_actions', CollectionType::class, array(
                'entry_type' => Action::class,
                'allow_add'  => true,
            ))
            ->add('home_injuries', null)
            ->add('home_skills', null)
            ->add('visitor_actions', CollectionType::class, array(
                'entry_type' => Action::class,
                'allow_add'  => true,
            ))
            ->add('visitor_injuries', null)
            ->add('visitor_skills', null)
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
