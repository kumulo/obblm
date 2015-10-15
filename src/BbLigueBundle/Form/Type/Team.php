<?php
namespace BbLigueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class Team extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null)
            ->add('ligue', 'entity', array(
                'class' => 'BbLigueBundle:Ligue',
                'choice_label' => 'name',
                'required' => true,
                'query_builder' => function(EntityRepository $repository) use ($options) {
                    $qb = $repository->createQueryBuilder('l')->orderBy('l.id', 'DESC');
                    $involvedligues = $options['data']->getCoach()
                        ->getInvolvedLigues()
                        ->map(function($ligue)  {
                            return $ligue->getId();
                        })->toArray();
                    if($involvedligues) {
                        // find all ligues where coach is not allready involved
                        $qb = $qb->where('l.id NOT IN (:ligues)')
                            ->setParameter('ligues', $involvedligues);
                    }
                    return $qb;
                },
            ))
            ->add('save', 'submit')
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLigueBundle\Entity\Team',
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_user_team';
    }
}
