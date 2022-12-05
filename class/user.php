<?php

class User
{
  protected $username;
  protected $password;
  protected $region;
  

  public function __construct(string $pseudonyme, string $pwd, string $city)
  {
    $this->username = $pseudonyme;
    $this->password = $pwd;
    $this->region = $city;
  }

  
}