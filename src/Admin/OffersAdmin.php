<?php

namespace App\Admin;

use App\Entity\Make;
use App\Entity\Offer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OffersAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title');
        $formMapper->add('text');
        $formMapper->add('active');
        $formMapper->add('active');
        $formMapper->add('make', Make::class, []);
//        $formMapper
//            ->add('make', ChoiceType::class, [
//                'choices' => [
//                    'prep' => 'Prepared',
//                    'prog' => 'In progress',
//                    'done' => 'Done'
//                ]
//            ]);
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
}