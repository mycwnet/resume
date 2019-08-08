<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoverLetterRepository")
 */
class CoverLetter {

    /**
     * @var int
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $index;

    /**
     * @var string 
     * @ORM\Column(name="addressee", type="string", length=255, nullable=true)
     */
    protected $addressee;

    /**
     * @var string 
     * @ORM\Column(name="letter", type="text", nullable=true)
     */
    protected $letter;

    /**
     * 
     * @ORM\OneToOne(targetEntity="Profile", inversedBy="coverletter")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $profile;

    public function getIndex() {
        return $this->index;
    }

    public function setIndex($user_id) {
        $this->index = $user_id;
    }

    public function getAddressee() {
        return $this->addressee;
    }

    public function setAddressee($addressee) {
        $this->addressee = $addressee;
    }

    public function getLetter() {
        return $this->letter;
    }

    public function setLetter($letter) {
        $this->letter = $letter;
    }

    /**
     * Set profile
     *
     * @param \App\Entity\Profile $profile
     *
     * @return Profile
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
