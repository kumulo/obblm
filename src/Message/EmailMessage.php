<?php

namespace BBlm\Message;

use Symfony\Component\Mime\Email;

class EmailMessage
{
    private $content;

    public function __construct(Email $content)
    {
        $this->content = $content;
    }

    public function getContent(): Email
    {
        return $this->content;
    }
}