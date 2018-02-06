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

class OffersAdmin extends AbstractAdmin
{
    protected $formOptions = [
        'validation_groups' => []
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title');
        $formMapper->add('text');
        $formMapper->add('active');
        $formMapper->add('active');
        $formMapper
            ->add('makeSlug', ChoiceType::class, [
                'choices' => [
                    'Audi' => 'audi',
                    'BMW' => 'bmw',
                ]
            ]);
        $formMapper->add('model');
        $formMapper->add('modelYear');
        $formMapper->add('includedTlpts');
        $formMapper->add('excludedTlpts');
        $formMapper->add('unassignedTlpts');
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