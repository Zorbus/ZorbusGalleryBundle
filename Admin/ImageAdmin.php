<?php

namespace Zorbus\GalleryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\MaxLength;
use Symfony\Component\Validator\Constraints\Image;

class ImageAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('gallery', null, array(
                    'required' => true,
                    'attr' => array('class' => 'span5 select2'),
                    'constraints' => array(
                        new NotBlank(),
                        new Type(array('type' => '\\Zorbus\\GalleryBundle\\Entity\\Gallery'))
                    )
                 ))
                ->add('title', null, array(
                    'constraints' => array(
                        new MaxLength(array('limit' => 255))
                    )
                ))
                ->add('thumbnailTemp', 'file', array(
                    'required' => false,
                    'label' => 'Thumbnail',
                    'constraints' => array(
                        new Image()
                    )
                ))
                ->add('imageTemp', 'file', array(
                    'required' => true,
                    'label' => 'Image',
                    'constraints' => array(
                        new NotBlank(),
                        new Image()
                    )
                ))
                ->add('position', null, array(
                    'constraints' => array(
                        new Min(array('limit' => 0))
                    )
                ))
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

    public function prePersist($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

    public function preUpdate($object)
    {
        $object->setUpdatedAt(new \DateTime());
    }

}