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
     * @ORM\Column(name="site_title", type="string", length=255, nullable=true)
     */
    private $site_title;

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
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Image(
     *     minWidth = 25,
     *     maxWidth = 100,
     *     minHeight = 25,
     *     maxHeight = 100
     * )
     */
    private $site_logo;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Image(
     *     minWidth = 16,
     *     maxWidth = 32,
     *     minHeight = 16,
     *     maxHeight = 32,
     *     allowLandscape = false,
     *     allowPortrait = false,
     *     minWidthMessage="favicon must be a square 16x16 or 32x32",
     *     maxWidthMessage="favicon must be a square 16x16 or 32x32",
     *     minHeightMessage="favicon must be a square 16x16 or 32x32",
     *     minHeightMessage="favicon must be a square 16x16 or 32x32",
     *     allowPortraitMessage="favicon must be a square 16x16 or 32x32",
     *     allowLandscapeMessage="favicon must be a square 16x16 or 32x32",
     * 
     * )
     */
    private $favicon_image;

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

    public function getIndex() {
        return $this->index;
    }

    public function setIndex($user_id) {
        $this->index = $user_id;
    }

    public function getSiteTitle() {
        return $this->site_title;
    }

    public function setSiteTitle($site_title) {
        $this->site_title = $site_title;
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
        $this->background_image = $background_image ? $background_image : $this->background_image;
    }

    public function getSiteLogo() {
        return $this->site_logo;
    }

    public function setSiteLogo($site_logo) {
        $this->site_logo = $site_logo ? $site_logo : $this->site_logo;
    }

    public function getFaviconImage() {
        return $this->favicon_image;
    }

    public function setFaviconImage($favicon_image) {
        $this->favicon_image = $favicon_image ? $favicon_image : $this->favicon_image;
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
