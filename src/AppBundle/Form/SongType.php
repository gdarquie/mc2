<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use AppBundle\Entity\Song;
use AppBundle\Repository\SongRepository;

use AppBundle\Entity\Thesaurus;

use AppBundle\Repository\ThesaurusRepository;
use AppBundle\Repository\PersonRepository;

class SongType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('date')
            ->add('lyricist'
                , EntityType::class, array(
                    'class' => 'AppBundle:Person',
                    'multiple' => true,
//                'empty_data' => null,
                    'choice_label' => 'name',
                    'query_builder' => function(PersonRepository $repo) {
                        return $repo->createAlphabeticalQueryBuilder();
                    }
                )
            )
            ->add('songtype', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("songtype");
                }
            ))
            ->add('composer'
                , EntityType::class, array(
                    'class' => 'AppBundle:Person',
                    'multiple' => true,
                    'choice_label' => 'name',
                    'query_builder' => function(PersonRepository $repo) {
                        return $repo->createAlphabeticalQueryBuilder();
                    }
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Song'
        ));
    }
}

