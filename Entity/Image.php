<?php

namespace Zorbus\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 */
class Image extends Base\Image
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $thumbnail;

    /**
     * @var string
     */
    private $image;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \Zorbus\GalleryBundle\Entity\Gallery
     */
    private $gallery;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Image
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Image
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Image
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Image
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Image
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Image
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set gallery
     *
     * @param \Zorbus\GalleryBundle\Entity\Gallery $gallery
     * @return Image
     */
    public function setGallery(\Zorbus\GalleryBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Zorbus\GalleryBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }
    /**
     * @ORM\PrePersist
     */
    public function preImageUpload()
    {
        if (null !== $this->imageTemp)
        {
            $this->image = sha1(uniqid(mt_rand(), true)) . '.' . $this->imageTemp->guessExtension();
        }
    }
    /**
     * @ORM\PrePersist
     */
    public function preThumbnailUpload()
    {
        if (null !== $this->thumbnailTemp)
        {
            $this->thumbnail = sha1(uniqid(mt_rand(), true)) . '.' . $this->thumbnailTemp->guessExtension();
        }
    }

    /**
     * @ORM\PostRemove
     */
    public function postRemove()
    {
        if ($file = $this->getAbsolutePath($this->image))
        {
            @unlink($file);
        }
        if ($file = $this->getAbsolutePath($this->thumbnail))
        {
            @unlink($file);
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function postImageUpload()
    {
        if ($this->imageTemp instanceof \Symfony\Component\HttpFoundation\File\UploadedFile)
        {
            $this->imageTemp->move($this->getUploadRootDir(), $this->image);

            unset($this->imageTemp);
        }
    }
    /**
     * @ORM\PostPersist
     */
    public function postThumbnailUpload()
    {
        if ($this->thumbnailTemp instanceof \Symfony\Component\HttpFoundation\File\UploadedFile)
        {
            $this->thumbnailTemp->move($this->getUploadRootDir(), $this->thumbnail);

            unset($this->thumbnailTemp);
        }
    }
}