<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectSamplesRepository")
 */
class ProjectSamples {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $index;

    /**
     * @var string
     * @ORM\Column(name="sampleindex", type="string", length=255)
     */
    private $sampleindex;

    /**
     * @var string 
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string 
     * @ORM\Column(name="blurb", type="string", length=255, nullable=true)
     */
    private $blurb;

    /**
     * @var string 
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 1000,
     *     minHeight = 200,
     *     maxHeight = 1000
     * )
     */
    private $project_image;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="projectsamples")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $profile;

    public function getIndex() {
        return $this->index;
    }

    public function getSampleIndex() {
        if(!$this->sampleindex){
            $this->setSampleIndex(md5(uniqid()));
        }
        return $this->sampleindex;
    }

    public function setSampleIndex($sampleindex) {
        $this->sampleindex = $sampleindex;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getBlurb() {
        return $this->blurb;
    }

    public function setBlurb($blurb) {
        $this->blurb = $blurb;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getProjectImage() {
        return $this->project_image;
    }

    public function setProjectImage($project_image) {
        if ($this->getTitle()) {
            $this->project_image = $project_image ? $project_image : $this->project_image;
        } else {
            $this->project_image = null;
        }
    }

    /**
     * Set profile
     *
     * @param \App\Entity\Profile $profile
     *
     * @return Proficiencies
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
