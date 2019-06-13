<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectHistoryRepository")
 */
class ProjectHistory {

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
     * @var string 
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @var string 
     * @ORM\Column(name="description", type="string", length=1024)
     */
    private $description;

    /**
     * @var string 
     * @ORM\Column(name="skills", type="string", length=255, nullable=true)
     */
    private $skills;

    /**
     * @var \DateTime 
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var \DateTime 
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="projecthistory")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $profile;

    public function getIndex() {
        return $this->index;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getSkills() {
        return $this->skills;
    }

    public function setSkills($skills) {
        $this->skills = $skills;
    }

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        $this->end = $end;
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
