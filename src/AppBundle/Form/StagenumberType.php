<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use AppBundle\Repository\PersonRepository;
use AppBundle\Repository\SongRepository;
use AppBundle\Repository\ThesaurusRepository;



class StagenumberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)

            ->add('order')

            ->add('costumes', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("costumes");
                },
                'required'    => false,
                'empty_data'  => null
            ))

            ->add('musical_thesaurus', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("musical_thesaurus");
                }
            ))

            ->add('dancemble', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'multiple' => true,
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("dancemble");
                }// il faudra ne prendre que ceux de type dance
            ))
            ->add('dancingType', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("dancing_type");
                }
            ))
            ->add('danceSubgenre', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("dance_subgenre");
                }
            ))
            ->add('danceContent', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("dance_content");
                }
            ))
            ->add('general_mood', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("general_mood");
                }// diviser par type ensuite
            ))
            ->add('genre', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("genre");
                }// diviser par type ensuite
            ))

            ->add('characters')
            ->add('description')
            ->add('ibdb')
            ->add('setting')
//            ->add('number')

            ->add('song', EntityType::class, array(
                'class' => 'AppBundle:Song',
                'multiple' => true,
                'empty_data' => null,
                'choice_label' => 'title',
                'query_builder' => function(SongRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                },
            ))
            ->add('musensemble', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("musensemble");
                }//il faudra ne prendre que ceux de type music
            ))
            ->add('performers'
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
            ->add('cast', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("cast");
                },
                'empty_data' => null,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Stagenumber'
        ));
    }
}
