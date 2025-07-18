<?php

namespace Chat\Model;

class Message
{
    public $id;
    public $senderId;
    public $receiverId;
    public $body;
    public $createdAt;

    public function __construct(int $senderId, int $receiverId, string $body)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->body = $body;
        $this->createdAt = date('Y-m-d H:i:s');
    }
}
