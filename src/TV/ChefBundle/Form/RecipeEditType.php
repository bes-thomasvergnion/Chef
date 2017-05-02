<?php

namespace TV\ChefBundle\Form;
use Symfony\Component\Form\AbstractType;

class RecipeEditType extends AbstractType
{
    public function getParent()
    {
        return RecipeType::class;
    }
}