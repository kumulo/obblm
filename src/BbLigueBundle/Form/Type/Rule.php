<?php
namespace BbLigueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Rule extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null)
            ->add('description', null)
            ->add('rule_key', null)
            ->add('rule', 'hidden', array(
                'mapped' => false,
                'data' => '',
            ))
            ->add('save', 'submit')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLigueBundle\Entity\Rule',
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_admin_rule';
    }
}
