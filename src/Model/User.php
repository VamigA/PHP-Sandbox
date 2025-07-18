<?php

namespace Chat\Model;

class User
{
    public $id;
    public $login;
    public $email;
    public $passwordHash;
    public $createdAt;

    public function __construct(string $login, string $email, string $passwordHash)
    {
        $this->login = $login;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = date('Y-m-d H:i:s');
    }
}
