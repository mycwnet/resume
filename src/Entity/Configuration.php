<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigurationRepository")
 */
class Configuration {

    /**
     * @var int
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $index;

    /**
     * @var string 
     * @ORM\Column(name="dateformat", type="string", length=255)
     */
    private $dateformat;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\Image(
     *     minWidth = 1000,
     *     maxWidth = 4000,
     *     minHeight = 500,
     *     maxHeight = 1000
     * )
     */
    private $background_image;

    /**
     * @var string 
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * 
     * @ORM\OneToOne(targetEntity="Profile", inversedBy="configuration")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $profile;
    
    public function getIndex(){
        return $this->dateformat;
    }
    public function setIndex($user_id){
       $this->index = $user_id;
    }

    public function getDateFormat() {
        return $this->dateformat;
    }

    public function setDateFormat($dateformat) {
        $this->dateformat = $dateformat;
    }

    public function getBackgroundImage() {
        return $this->background_image;
    }

    public function setBackgroundImage($background_image) {
        $this->background_image = $background_image?$background_image:$this->background_image;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }
    
    /**
     * Set profile
     *
     * @param \App\Entity\Profile $profile
     *
     * @return ProjectHistory
     */
    public function setProfile(\App\Entity\Profile $profile = null) {
        $this->profile = $profile;
        return $this;
    }

    /**
     * Get profile
     *
     * @return \App\Entity\Profile
     */
    public function getProfile() {
        return $this->profile;
    }

}
