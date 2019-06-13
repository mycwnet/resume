<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\BrandIconsApiController;

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
     * @var string 
     * @ORM\Column(name="category", type="string", length=255, nullable=true)
     */
    private $category;

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
     * @var string 
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="proficiencies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $profile;
    private $icon_list;
    private $icon_value;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
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

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
    }

    public function getIconList() {
        return $this->icon_list;
    }

    public function setIconList($list = []) {
        if ($this->title) {
            $brand_icons = new BrandIconsApiController();
            $list = $brand_icons->brandIconsSearchApi($this->title);
        }

        return $list;
    }

    public function getIconValue() {
        return $this->icon_value;
    }

    public function setIconValue($icon_value) {
        $this->icon_value = $icon_value;
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
