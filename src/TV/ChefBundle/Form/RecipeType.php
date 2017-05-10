<?php

namespace TV\ChefBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
                    'required'  => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
                ->add('types', EntityType::class, array(
                    'class' => 'TVChefBundle:Type',
                    'multiple'     => true,
                    'expanded'     => true,
                    'required'  => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
                ->add('categories', EntityType::class, array(
                    'class' => 'TVChefBundle:Category',
                    'multiple'     => true,
                    'expanded'     => true,
                    'required'  => false,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
                ->add('localities', EntityType::class, array(
                    'class' => 'TVChefBundle:Locality',
                    'multiple'     => true,
                    'expanded'     => true,
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
