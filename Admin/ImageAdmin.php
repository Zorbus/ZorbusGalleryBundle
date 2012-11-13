<?php

namespace Zorbus\GalleryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class ImageAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('gallery', null, array('required' => true, 'attr' => array('class' => 'span5 select2')))
                ->add('title')
                ->add('thumbnailTemp', 'file', array('required' => false, 'label' => 'Thumbnail'))
                ->add('imageTemp', 'file', array('required' => true, 'label' => 'Image'))
                ->add('position')
                ->add('enabled', null, array('required' => false))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('title')
                ->add('gallery')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('title')
                ->addIdentifier('gallery')
                ->add('enabled')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
                ->with('gallery')
                ->assertNotBlank()
                ->assertType(array('type' => '\\Zorbus\\GalleryBundle\\Entity\\Gallery'))
                ->end()
                ->with('title')
                ->assertMaxLength(array('limit' => 255))
                ->end()
                ->with('imageTemp')
                ->assertNotBlank()
                ->assertImage()
                ->end()
                ->with('thumbnailTemp')
                ->assertImage()
                ->end()
                ->with('position')
                ->assertMin(array('limit' => 0))
                ->end()
        ;
    }

    public function prePersist($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

}