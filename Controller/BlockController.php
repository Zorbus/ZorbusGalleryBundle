<?php

namespace Zorbus\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    public function galleryAction($block, $page, $request)
    {
        $parameters = json_decode($block->getParameters());
        $gallery = $this->getDoctrine()->getRepository('ZorbusGalleryBundle:Gallery')->find($parameters->gallery_id);

        return $this->render('ZorbusGalleryBundle:Block:gallery.html.twig', array(
            'block' => $block, 'gallery' => $gallery
        ));
    }
    public function categoryAction($block, $page, $request)
    {
        $parameters = json_decode($block->getParameters());
        $category = $this->getDoctrine()->getRepository('ZorbusGalleryBundle:Category')->find($parameters->category_id);

        return $this->render('ZorbusGalleryBundle:Block:category.html.twig', array(
            'block' => $block, 'category' => $category
        ));
    }
}
