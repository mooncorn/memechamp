<?php

namespace App\Models;

class User {
  protected $id;
  protected $email;
  protected $username;

  public function setId(int $id) {
    $this->id = $id;
  }

  public function setEmail(string $email) {
    $this->email = $email;
  }

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }
}