<?php

namespace App\Dto\Utils\ApollopaymentApi;

use App\Dto\DtoInterface;

class CreateUserDto implements DtoInterface
{
    public function __construct(
        private ?string $clientId,
        private ?string $clientEmail,
        private ?string $clientName,
        private ?string $depositWebhookUrl,
        private ?bool   $createAddresses = true,
        private ?bool   $groupByBlockchain = true,
        private ?bool   $checkRisks = true,
    )
    {
    }

    /**
     * @param array $args
     * @return DtoInterface|self
     */
    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['clientId'] ?? null,
            $args['clientEmail'] ?? null,
            $args['clientName'] ?? null,
            $args['depositWebhookUrl'] ?? null,
            $args['createAddresses'] ?? true,
            $args['groupByBlockchain'] ?? true,
            $args['checkRisks'] ?? true,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'clientId' => $this->clientId,
            'clientEmail' => $this->clientEmail,
            'clientName' => $this->clientName,
            'depositWebhookUrl' => $this->depositWebhookUrl,
            'createAddresses' => $this->createAddresses,
            'groupByBlockchain' => $this->groupByBlockchain,
            'checkRisks' => $this->checkRisks,
        ]);
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * @param string|null $clientId
     * @return void
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string|null
     */
    public function getClientEmail(): ?string
    {
        return $this->clientEmail;
    }

    /**
     * @param string|null $clientEmail
     * @return void
     */
    public function setClientEmail(?string $clientEmail): void
    {
        $this->clientEmail = $clientEmail;
    }

    /**
     * @return string|null
     */
    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    /**
     * @param string|null $clientName
     * @return void
     */
    public function setClientName(?string $clientName): void
    {
        $this->clientName = $clientName;
    }

    /**
     * @return string|null
     */
    public function getDepositWebhookUrl(): ?string
    {
        return $this->depositWebhookUrl;
    }

    /**
     * @param string|null $depositWebhookUrl
     * @return void
     */
    public function setDepositWebhookUrl(?string $depositWebhookUrl): void
    {
        $this->depositWebhookUrl = $depositWebhookUrl;
    }

    /**
     * @return bool|null
     */
    public function getCreateAddresses(): ?bool
    {
        return $this->createAddresses;
    }

    /**
     * @param bool|null $createAddresses
     * @return void
     */
    public function setCreateAddresses(?bool $createAddresses): void
    {
        $this->createAddresses = $createAddresses;
    }

    /**
     * @return bool|null
     */
    public function getGroupByBlockchain(): ?bool
    {
        return $this->groupByBlockchain;
    }

    /**
     * @param bool|null $groupByBlockchain
     * @return void
     */
    public function setGroupByBlockchain(?bool $groupByBlockchain): void
    {
        $this->groupByBlockchain = $groupByBlockchain;
    }

    /**
     * @return bool|null
     */
    public function getCheckRisks(): ?bool
    {
        return $this->checkRisks;
    }

    /**
     * @param bool|null $checkRisks
     * @return void
     */
    public function setCheckRisks(?bool $checkRisks): void
    {
        $this->checkRisks = $checkRisks;
    }
}
