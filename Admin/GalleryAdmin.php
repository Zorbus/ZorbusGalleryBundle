<?php

namespace Zorbus\GalleryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class GalleryAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->with('Identification')
                ->add('title')
                ->add('resume', 'textarea', array('required' => false, 'attr' => array('class' => 'ckeditor')))
                ->add('description', 'textarea', array('required' => false, 'attr' => array('class' => 'ckeditor')))
                ->add('local')
                ->add('period', null, array('label' => 'Date'))
                ->end()
                ->with('Configuration', array('collapsed' => false))
                ->add('category', null, array('required' => false, 'attr' => array('class' => 'span5 select2')))
                ->add('imageTemp', 'file', array('required' => false, 'label' => 'Image'))
                ->add('position', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
                ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('title')
                ->add('category')
                ->add('enabled')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('title')
                ->addIdentifier('category')
                ->add('enabled')
        ;
    }

    public function configureShowFields(ShowMapper $filter)
    {
        $filter
                ->add('title')
                ->add('resume')
                ->add('description')
                ->add('category')
                ->add('position')
                ->add('image')
                ->add('local')
                ->add('enabled')
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
                ->with('title')
                ->assertNotBlank()
                ->assertMaxLength(array('limit' => 255))
                ->end()
                ->with('imageTemp')
                ->assertImage()
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