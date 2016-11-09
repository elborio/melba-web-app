<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 11/7/2016
 * Time: 1:25 PM
 */

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupSelectorType extends AbstractType
{
    private $groupOptions;

    public function __construct(array $groupOptions)
    {
        $this->groupOptions = $groupOptions;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', EntityType::class, array(
                'class' => 'AppBundle\Entity\Group',
                'choice_label' => 'name'
            ))
        ;

    }


}