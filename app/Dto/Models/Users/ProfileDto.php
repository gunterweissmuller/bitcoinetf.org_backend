<?php

declare(strict_types=1);

namespace App\Dto\Models\Users;

use App\Dto\DtoInterface;

final class ProfileDto implements DtoInterface
{
    public function __construct(
        private ?string $accountUuid,
        private ?string $fullName,
        private ?string $dateOfBirth,
        private ?string $taxResidence,
        private ?string $address,
        private ?string $city,
        private ?string $postalCode,
        private ?string $state,
        private ?string $country,
        private ?string $createdAt,
        private ?string $updatedAt,
    ) {
    }

    public static function fromArray(array $args): DtoInterface|self
    {
        return new self(
            $args['account_uuid'] ?? null,
            $args['full_name'] ?? null,
            $args['date_of_birth'] ?? null,
            $args['tax_residence'] ?? null,
            $args['address'] ?? null,
            $args['city'] ?? null,
            $args['postal_code'] ?? null,
            $args['state'] ?? null,
            $args['country'] ?? null,
            $args['created_at'] ?? null,
            $args['updated_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'account_uuid' => $this->accountUuid,
            'full_name' => $this->fullName,
            'date_of_birth' => $this->dateOfBirth,
            'tax_residence' => $this->taxResidence,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postalCode,
            'state' => $this->state,
            'country' => $this->country,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    /**
     * @return string|null
     */
    public function getAccountUuid(): ?string
    {
        return $this->accountUuid;
    }

    /**
     * @param  string|null  $accountUuid
     */
    public function setAccountUuid(?string $accountUuid): void
    {
        $this->accountUuid = $accountUuid;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param  string|null  $fullName
     */
    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string|null
     */
    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    /**
     * @param  string|null  $dateOfBirth
     */
    public function setDateOfBirth(?string $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string|null
     */
    public function getTaxResidence(): ?string
    {
        return $this->taxResidence;
    }

    /**
     * @param  string|null  $taxResidence
     */
    public function setTaxResidence(?string $taxResidence): void
    {
        $this->taxResidence = $taxResidence;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param  string|null  $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param  string|null  $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param  string|null  $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param  string|null  $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param  string|null  $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param  string|null  $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param  string|null  $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
