<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProficienciesRepository")
 */
class Proficiencies {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $index;

    /**
     * @var string 
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    /**
     * @var int
     * @ORM\Column(name="years", type="integer")
     */
    private $years;
     /**
     * @var int
     * @ORM\Column(name="percent", type="integer")
     */
    private $percent;   

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="proficiencies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $profile;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getYears() {
        return $this->years;
    }

    public function setYears($years) {
        $this->years = $years;
    }

    public function getPercent() {
        return $this->percent;
    }

    public function setPercent($percent) {
        $this->percent = $percent;
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
