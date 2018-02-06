<?php

namespace App\Admin;

use App\Entity\Make;
use App\Entity\Offer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class OffersAdmin extends AbstractAdmin
{
    protected $formOptions = [
        'validation_groups' => [],
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('Info')
            ->add('title')
            ->add('text')
            ->add('active')
            ->end()
            ->with('Query')
            ->add('makeSlug', ChoiceType::class, [
                'choices' => [
                    'Audi' => 'audi',
                    'BMW' => 'bmw',
                ],
            ])
            ->add('model')
            ->add('modelYear')
            ->end()
            ->with('Vehicles', ['box_class' => 'js-vehicles-section box box-primary'])
            ->add('includedTlpts', null, ['attr' => ['class' =>'future-hidden']])
            ->add('excludedTlpts', null, ['attr' => ['class' =>'future-hidden']])
            ->add('unassignedTlpts', null, ['attr' => ['class' =>'future-hidden']])
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('active');
        $listMapper->addIdentifier('title');
        $listMapper->add('make');
        $listMapper->add('model');
        $listMapper->add('modelYear');
        $listMapper->add('includedTlpts');
        $listMapper->add('excludedTlpts');
        $listMapper->add('unassignedTlpts');
    }

    public function toString($object)
    {
        return $object instanceof Offer
            ? $object->title
            : 'Offer'; // shown in the breadcrumb on the create view
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('makeSlug')
            ->assertLength(['max' => 255])
            ->end()
        ;
    }
}
