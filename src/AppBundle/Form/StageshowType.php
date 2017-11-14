<?php

namespace AppBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\ThesaurusRepository;
use AppBundle\Repository\PersonRepository;
use AppBundle\Repository\StageshowRepository;

use AppBundle\Entity\Stageshow;
use AppBundle\Entity\Thesaurus;

class StageshowType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('production')
            ->add('opening', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'], // Creates a dropdown of 15 years to control year
                'html5' => false
            ])
            ->add('films')
            ->add('ibdb')
            ->add('race')
            ->add('status')
            ->add('closing', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
                'html5' => false,
            ])
            ->add('count')
            ->add('comment')
            ->add('composers')
            ->add('books')
            ->add('lyricists')
            ->add('choreographers')
            ->add('directors')
            ->add('designs')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Stageshow'
        ));
    }
}