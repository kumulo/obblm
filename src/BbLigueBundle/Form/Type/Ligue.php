<?php
namespace BbLigueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Ligue extends AbstractType
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
            ->add('save', 'submit')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLigueBundle\Entity\Ligue',
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_admin_ligue';
    }
}
