<?php

namespace TV\ChefBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', TextType::class, array(
                'label' => 'quantité: ',
                'attr' => array('placeholder' => '4, 500,...')
            ))
            ->add('typequantity', EntityType::class, array(
                'class' => 'TVChefBundle:TypeQuantity',
                'placeholder' => '--',
                'required'  => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nom: ',
                'attr' => array('placeholder' => 'exemple: de lait, de riz, d\'ail ' )
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
            'data_class' => 'TV\ChefBundle\Entity\Ingredient'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tv_chefbundle_ingredient';
    }


}
