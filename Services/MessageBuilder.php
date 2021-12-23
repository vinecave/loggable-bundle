<?php

namespace Vinecave\Bundle\LoggableBundle\Services;

class MessageBuilder
{
    public function buildMessage(array $data): string
    {
        return '¢' . json_encode($data) . '¢';
    }
}
