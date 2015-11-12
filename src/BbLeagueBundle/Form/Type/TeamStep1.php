<?php
namespace BbLeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class TeamStep1 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('league', 'entity', array(
                'class' => 'BbLeagueBundle:League',
                'choice_label' => 'name',
                'required' => true,
                'query_builder' => function(EntityRepository $repository) use ($options) {
                    $qb = $repository->createQueryBuilder('l')->orderBy('l.id', 'DESC');
                    $involvedleagues = $options['data']->getCoach()
                        ->getInvolvedLeagues()
                        ->map(function(\BbLeagueBundle\Entity\League $league)  {
                            return $league->getId();
                        })->toArray();
                    if($involvedleagues) {
                        // find all leagues where coach is not allready involved
                        $qb = $qb->where('l.id NOT IN (:leagues)')
                            ->setParameter('leagues', $involvedleagues);
                    }
                    return $qb;
                },
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLeagueBundle\Entity\Team',
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_forms_user_team';
    }
}
