<?php

namespace App\Entity;

class Profile {

    protected $title;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $phone;
    protected $image;
    protected $background;
    protected $project_history;
    protected $proficiencies;

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
    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getBackground() {
        return $this->background;
    }

    public function setBackground($background) {
        $this->background = $background;
    }

    public function getProjectHistory() {
        return $this->project_history;
    }

    public function setProjectHistory($project_history) {
        $this->project_history = $project_history;
    }

    public function getProficiencies() {
        return $this->proficiencies;
    }

    public function setProficiencies($proficiencies) {
        $this->proficiencies = $proficiencies;
    }

}
