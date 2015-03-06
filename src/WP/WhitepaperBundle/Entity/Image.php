<?php

namespace WP\WhitepaperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    private $filenameForRemove;

    /**
     * @Assert\File(maxSize="6000000")
     * @Assert\Image()
     */
    public $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->id.'.'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->id.'.'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/images';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->image) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = $this->image->guessExtension();
//            $this->size = $this->file->getClientSize();
//            $this->token = sha1(uniqid(mt_rand(), true));
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->image) {
            return;
        }

        $this->image->move($this->getUploadRootDir(), $this->id.'.'.$this->image->guessExtension());

        unset($this->image);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($this->filenameForRemove) {
            unlink($this->filenameForRemove);
        }
    }

    public function getImage()
    {
        return $this->image;
    }
    public function setImage(UploadedFile $image)
    {
        $this->image = $image;

        $this->image = $image;
        // On vérifie si on avait déjà un fichier pour cette entité
        if (null !== $this->path) {
            // On sauvegarde l'extension du fichier pour le supprimer plus tard
            $this->filenameForRemove = $this->path;
            // On réinitialise les valeurs des attributs url et alt
            $this->path = null;
//            $this->size = null;
//            $this->token = null;
        }
    }

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
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
}
