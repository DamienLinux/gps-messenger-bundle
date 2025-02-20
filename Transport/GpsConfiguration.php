<?php

declare(strict_types=1);

namespace PetitPress\GpsMessengerBundle\Transport;

/**
 * @author Ronald Marfoldi <ronald.marfoldi@petitpress.sk>
 */
final class GpsConfiguration implements GpsConfigurationInterface
{
    private string $topicName;
    private string $subscriptionName;
    private int $maxMessagesPull;
    private array $clientConfig;
    private array $topicOptions;
    private array $subscriptionOptions;

    public function __construct(
        string $queueName,
        string $subscriptionName,
        int $maxMessagesPull,
        array $clientConfig,
        array $topicOptions,
        array $subscriptionOptions
    ) {
        $this->topicName = $queueName;
        $this->subscriptionName = $subscriptionName;
        $this->maxMessagesPull = $maxMessagesPull;
        $this->clientConfig = $clientConfig;
        $this->topicOptions = $topicOptions;
        $this->subscriptionOptions = $subscriptionOptions;
    }

    public function getTopicName(): string
    {
        return $this->topicName;
    }

    public function getSubscriptionName(): string
    {
        return $this->subscriptionName;
    }

    public function getMaxMessagesPull(): int
    {
        return $this->maxMessagesPull;
    }

    public function getClientConfig(): array
    {
        return $this->clientConfig;
    }

    public function getTopicOptions(): array
    {
        return $this->topicOptions;
    }

    public function getSubscriptionOptions(): array
    {
        return $this->subscriptionOptions;
    }
}
