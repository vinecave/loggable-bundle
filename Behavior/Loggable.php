<?php

namespace Vinecave\Bundle\LoggableBundle\Behavior;

use Vinecave\Bundle\LoggableBundle\Behavior\FeatureInterface;
use Vinecave\Bundle\LoggableBundle\Services\MessageBuilder;
use Monolog\Logger;
use Psr\Log\LoggerInterface;


trait Loggable
{
    protected LoggerInterface $logger;

    protected MessageBuilder $messageBuilder;

    private function logMessage(array $data, string $level = Logger::INFO): void
    {
        if ($this instanceof FeatureInterface) {
            $data['loggable.feature'] = $this::getFeature();
        }

        if ($this->isLogged()) {
            $message = $this->buildMessage($data);

            $this->logger->log($level, $message, []);
        }
    }

    public function logError(array $data): void
    {
        $this->logMessage($data, Logger::ERROR);
    }

    public function logInfo(array $data): void
    {
        $this->logMessage($data);
    }

    public function logAlert(array $data): void
    {
        $this->logMessage($data, Logger::ALERT);
    }

    public function logNotice(array $data): void
    {
        $this->logMessage($data, Logger::NOTICE);
    }

    public function logCritical(array $data): void
    {
        $this->logMessage($data, Logger::CRITICAL);
    }

    public function logDebug(array $data): void
    {
        $this->logMessage($data, Logger::DEBUG);
    }

    public function buildMessage(array $data): string
    {
        return $this->messageBuilder->buildMessage($data);
    }

    /**
     * @required
     */
    public function setMessageBuilder(MessageBuilder $messageBuilder): void
    {
        $this->messageBuilder = $messageBuilder;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function isLogged(): bool
    {
        return true;
    }
}
