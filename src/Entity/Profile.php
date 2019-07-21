<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\ProjectHistory;
use App\Entity\Proficiencies;
use App\Entity\ProjectSamples;
use App\Entity\Configuration;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile {

    /**
     * @var int 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    protected $user_id;

    /**
     * @var string 
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string 
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    protected $first_name;

    /**
     * @var string 
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    protected $last_name;

    /**
     * @var string 
     * @ORM\Column(name="email", type="string", length=255)
     */
    protected $email;

    /**
     * @var string 
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var string 
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    protected $location;

    /**
     * @var string 
     * @ORM\Column(name="linkedin", type="string", length=255, nullable=true)
     */
    protected $linkedin;

    /**
     * @var string 
     * @ORM\Column(name="github", type="string", length=255, nullable=true)
     */
    protected $github;

    /**
     * @var string 
     * @ORM\Column(name="gitlab", type="string", length=255, nullable=true)
     */
    protected $gitlab;

    /**
     * @ORM\Column(type="string",  nullable=true)
     *
     * @Assert\Image(
     *     minWidth = 200,
     *     maxWidth = 600,
     *     minHeight = 200,
     *     maxHeight = 600
     * )
     */
    protected $image;

    /**
     * @var string 
     * @ORM\Column(name="background", type="text")
     */
    protected $background;

    /**
     * @var string 
     * @ORM\Column(name="summary", type="string", length=1024, nullable=true)
     */
    protected $summary;

    /**
     * @ORM\OneToMany(targetEntity="ProjectHistory", mappedBy="profile", cascade={"persist"}, orphanRemoval=true)
     */
    protected $project_history;

    /**
     * @ORM\OneToMany(targetEntity="Proficiencies", mappedBy="profile", cascade={"persist"}, orphanRemoval=true)
     */
    protected $proficiencies;

    /**
     * @ORM\OneToMany(targetEntity="ProjectSamples", mappedBy="profile", cascade={"persist"}, orphanRemoval=true)
     */
    protected $project_samples;

    /**
     * @ORM\OneToOne(targetEntity="Configuration", mappedBy="profile", cascade={"persist"})
     */
    protected $configuration;

    /**
     * Constructor
     */
    public function __construct() {

        $this->project_history = new \Doctrine\Common\Collections\ArrayCollection();
        $this->proficiencies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->project_samples = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setUserId($user = null) {
        $this->user_id = $user->getId();
    }

    /**
     * Add project_history
     *
     * @param \App\Entity\ProjectHistory $project_history
     *
     * @return Profile
     */
    public function addProjectHistory(ProjectHistory $project_history) {
        $this->project_history[] = $project_history;

        $project_history->setProfile($this);
        return $this;
    }

    /**
     * Remove project_history
     *
     * @param \App\Entity\ProjectHistory $project_history
     */
    public function removeProjectHistory(ProjectHistory $project_history) {
        $this->project_history->removeElement($project_history);
    }

    /**
     * Get project_history
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectHistory() {
        return $this->project_history;
    }

    /**
     * Add proficiencies
     *
     * @param \App\Entity\Proficiencies $proficiencies
     *
     * @return Profile
     */
    public function addProficiency(Proficiencies $proficiencies) {
        $this->proficiencies[] = $proficiencies;

        $proficiencies->setProfile($this);
        return $this;
    }

    /**
     * Remove proficiencies
     *
     * @param \App\Entity\Proficiencies $proficiencies
     */
    public function removeProficiency(Proficiencies $proficiencies) {
        $this->proficiencies->removeElement($proficiencies);
    }

    /**
     * Get proficiencies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProficiencies() {
        return $this->proficiencies;
    }

    /**
     * Add project sample
     *
     * @param \App\Entity\ProjectSamples $project_sample
     *
     * @return Profile
     */
    public function addProjectSample(ProjectSamples $project_sample) {
        $this->project_samples[] = $project_sample;

        $project_sample->setProfile($this);
        return $this;
    }

    /**
     * Remove project sample
     *
     * @param \App\Entity\ProjectSamples $project_sample
     */
    public function removeProjectSample(ProjectSamples $project_sample) {
        $this->project_samples->removeElement($project_sample);
        $project_sample->setProfile(null);
    }

    /**
     * Get project samples
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjectSamples() {
        return $this->project_samples;
    }

    /**
     * Set configuration
     *
     * @param \App\Entity\Configuration $configuration
     *
     * @return Profile
     */
    public function setConfiguration(Configuration $configuration) {
        $this->configuration = $configuration;

        $configuration->setProfile($this);
        return $this;
    }

    /**
     * Get configuration
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConfiguration() {
        return $this->configuration;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getLinkedIn() {
        return $this->linkedin;
    }

    public function setLinkedIn($linkedin) {
        $user = $this->getWebUserValue($linkedin);
        $profile = "https://www.linkedin.com/in/" . $user;
        $this->linkedin = $profile;
    }

    public function getGitHub() {
        return $this->github;
    }

    public function setGitHub($github) {
        $user = $this->getWebUserValue($github);
        $profile = "https://github.com/" . $user;
        $this->github = $profile;
    }

    public function getGitLab() {
        return $this->gitlab;
    }

    public function setGitLab($gitlab) {
        $user = $this->getWebUserValue($gitlab);
        $profile = "https://gitlab.com/" . $user;
        $this->gitlab = $profile;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image ? $image : $this->image;
    }

    public function getBackground() {
        return $this->background;
    }

    public function setBackground($background) {
        $this->background = $background;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function setSummary($summary) {
        $this->summary = $summary;
    }

    private function getWebUserValue($value) {
        $position = strrpos($value, '/');
        $webuser = $position === false ? $value : substr($value, $position + 1);
        return $webuser;
    }

}
