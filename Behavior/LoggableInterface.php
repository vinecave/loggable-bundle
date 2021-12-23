<?php

namespace Vinecave\Bundle\LoggableBundle\Behavior;

use Psr\Log\LoggerAwareInterface;
use Vinecave\Bundle\CollectionBundle\Behavior\NamedInterface;

interface LoggableInterface extends LoggerAwareInterface, NamedInterface
{
    public function logError(array $data): void;

    public function logInfo(array $data): void;

    public function logAlert(array $data): void;

    public function logNotice(array $data): void;

    public function logCritical(array $data): void;

    public function logDebug(array $data): void;

    public function buildMessage(array $data): string;
    
    public static function isLogged(): bool;
}
