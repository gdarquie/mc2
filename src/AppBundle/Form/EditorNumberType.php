<?php

namespace AppBundle\Form;

use AppBundle\Repository\StagenumberRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Repository\PersonRepository;
use AppBundle\Repository\SongRepository;
use AppBundle\Repository\ThesaurusRepository;

class EditorNumberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //title

            ->add('title', TextType::class, array(
            ))
            ->add('commentTitle')
            ->add('completeTitle', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])
            //length
            ->add('beginTc') // convertir en min/secondes
            ->add('endTc') // convertir en min/secondes


            //Outlines

            ->add('beginThesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("begin_thesaurus");
                },
                'empty_data' => null,
            ))
            ->add('endingThesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("ending_thesaurus");
                },
                'empty_data' => null
            ))
            ->add('completenessThesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("completeness_thesaurus");
                }
            ))


            //Structure

            ->add('completOptions', EntityType::class, array(
                'placeholder' => '',
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("complet_options");
                }
            ))
            ->add('commentTc')
            ->add('completeTc', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //structure

            ->add('structure', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("structure");
                }
            ))
            ->add('commentStructure')
            ->add('completeStructure', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])



            //Shots

            ->add('shots')
            ->add('commentShots')
            ->add('completeShots', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])
//            ->add('validationShots')

            //Performers

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
            ->add('figurants', EntityType::class, array(
                'class' => 'AppBundle:Person',
                'multiple' => true,
                'choice_label' => 'name',
                'query_builder' => function(PersonRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
            ->add('performance_thesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title',
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("performance_thesaurus");
                }
            ))
            ->add('commentPerformance')
            ->add('completePerformance', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //Backstage

            ->add('spectators_thesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title',
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("spectators_thesaurus");
                }
            ))
            //->add('diegtic',)
            ->add('diegetic_thesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title',
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("diegetic_thesaurus");
                }
            ))
            //->add('musician')
            ->add('musician_thesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title',
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("musician_thesaurus");
                }
            ))

            ->add('commentBackstage')
            ->add('completeBackstage', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //Themes

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


            ->add('stereotype', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("stereotype");
                }
            ))
            ->add('diegetic_place_thesaurus', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title',
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("diegetic_place_thesaurus");
                }
            ))
            ->add('general_localisation', EntityType::class, array(

                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("general_localisation");
                }
            ))
            ->add('imaginary', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("imaginary");
                }
            ))
            ->add('exoticism_thesaurus', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("exoticism_thesaurus");
                }
            ))
            ->add('commentTheme')
            ->add('completeTheme', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //Mood

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
                    return $repo->findAllThesaurusByCode( "genre");
                }// diviser par type ensuite
            ))
            ->add('commentMood')
            ->add('completeMood', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //Dance

            ->add('choregraphers', EntityType::class, array(
                'class' => 'AppBundle:Person',
                'multiple' => true,
                'choice_label' => 'name',
                'query_builder' => function(PersonRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
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
                    return $repo->findAllThesaurusByCode("dancing_type", "Dancing type");
                }
            ))
            ->add('danceSubgenre', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("dance_subgenre", "Dance sub-genre");
                }
            ))
            ->add('danceContent', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("dance_content", "Dance content");
                }
            ))
            ->add('commentDance')
            ->add('completeDance', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //music

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
            ->add('dubbing')
            ->add('tempo_thesaurus', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("tempo_thesaurus");
                }//il faudra ne prendre que ceux de type music
            ))
            ->add('musical_thesaurus', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("musical_thesaurus");
                }//il faudra ne prendre que ceux de type music
            ))
            ->add('arrangers', EntityType::class, array(
                'class' => 'AppBundle:Person',
                'multiple' => true,
                'choice_label' => 'name',
                'query_builder' => function(PersonRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
            ->add('arrangerComment')
            ->add('commentMusic')
            ->add('completeMusic', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //Complement

            ->add('director', EntityType::class, array(
                'class' => 'AppBundle:Person',
                'multiple' => true,
                'choice_label' => 'name',
                'query_builder' => function(PersonRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                }
            ))
            ->add('cost')
            ->add('costComment')
            ->add('commentDirector')
            ->add('completeDirector', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])


            //Reference

            ->add('quotation_thesaurus', EntityType::class, array(
                'multiple' => true,
                'class' => 'AppBundle:Thesaurus',
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("quotation_thesaurus");
                }
            ))
            ->add('quotation_text')
            //->add('source')
            ->add('source_thesaurus', EntityType::class, array(
                'class' => 'AppBundle:Thesaurus',
                'placeholder' => "",
                'multiple' => true,
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("source_thesaurus");
                }
            ))
            ->add('commentReference')
            ->add('completeReference', ChoiceType::class, [
                'choices' =>[
                    "not complete" => 0,
                    "complete" => 1,
                    "complete for me but need help" => 2,
                ]
            ])
            ->add('lyrics')
            ->add('cast', EntityType::class, array(
                'placeholder' => '',
                'class' => 'AppBundle:Thesaurus',
                'choice_label' => 'title', //order by alpha
                'query_builder' => function(ThesaurusRepository $repo) {
                    return $repo->findAllThesaurusByCode("cast");
                },
                'empty_data' => null,
            ))
            ->add('stagenumbers', EntityType::class, array(
                'class' => 'AppBundle:Stagenumber',
                'multiple' => true,
                'empty_data' => null,
                'choice_label' => 'title',
                'query_builder' => function(StagenumberRepository $repo) {
                    return $repo->createAlphabeticalQueryBuilder();
                },
            ))


            //Validations

            ->add('validationTitle', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationDirector', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationTc', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationStructure', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationShots', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationPerformance', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationBackstage', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationTheme', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationMood', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationDance', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationMusic', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationReference', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('validationCost', CollectionType::class, [
                'entry_type' => ValidationEmbeded::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
            ])


        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Number',
        ));
    }
}
