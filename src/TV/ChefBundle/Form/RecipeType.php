<?php

namespace TV\ChefBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class)
                ->add('level', EntityType::class, array(
                    'class' => 'TVChefBundle:Level',
                    'placeholder' => '--',
                    'required'  => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
                ->add('type', EntityType::class, array(
                    'class' => 'TVChefBundle:Type',
                    'placeholder' => '--',
                    'required'  => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
                ->add('category', EntityType::class, array(
                    'class' => 'TVChefBundle:Category',
                    'placeholder' => '--',
                    'required'  => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
                ->add('locality', EntityType::class, array(
                    'class' => 'TVChefBundle:Locality',
                    'placeholder' => '--',
                    'required'  => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
                ->add('nbOfPers', TextType::class)
                ->add('cookingTime', TextType::class)
                ->add('preparationTime', TextType::class)
                ->add('timeout', TextType::class)
                ->add('image', ImageType::class, array('required' => false))
                ->add('ingredients', CollectionType::class, array(
                    'entry_type'   => IngredientType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'label' =>false
                 ))
                ->add('steps', CollectionType::class, array(
                    'entry_type'   => StepType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'label' =>false
                 ))
                
                ->add('save', SubmitType::class, array(
                        'attr' => array('class' => 'save'),
                ))        
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TV\ChefBundle\Entity\Recipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tv_chefbundle_recipe';
    }


}
