<?php
namespace BbLigueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class Ligue extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null)
            ->add('rule', 'entity', array(
                'class' => 'BbLigueBundle:Rule',
                'choice_label' => 'name',
                'required' => true,
                /*'query_builder' => function(EntityRepository $repository) use ($options) {
                    $qb = $repository->createQueryBuilder('l');
                    // the function returns a QueryBuilder object
                    $involvedligues = $options['data']->getCoach()
                        ->getInvolvedLigues()
                        ->map(function($ligue)  {
                            return $ligue->getId();
                        })->toArray();
                    return $qb
                        // find all ligues where coach is not allready involved
                        ->where('l.id NOT IN (:ligues)')
                        ->setParameter('ligues', $involvedligues)
                        ->orderBy('l.name', 'ASC')
                    ;
                },*/
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
