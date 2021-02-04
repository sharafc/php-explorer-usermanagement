<?php

interface CustomerInterface
{
    public function __construct(
        ?int $id,
        ?string $firstname = NULL,
        ?string $lastname = NULL,
        ?string $email = NULL,
        ?DateTime $birthdate = NULL,
        ?string $city = NULL
    );

    public static function fetchAllCustomersFromDb(PDO $pdo): ?array;

    public function saveToDb(PDO $pdo): bool;
    public function fetchFromDb(PDO $pdo): bool;
    public function updateToDb(PDO $pdo): bool;
    public function deleteFromDb(PDO $pdo): bool;
    public function emailExistsInDb(PDO $pdo): bool;

    public function getFullname(): string;

    public function getCus_id(): ?int;
    public function setCus_id(?int $value);

    public function getCus_firstname(): ?string;
    public function setCus_firstname(?string $value);

    public function getCus_lastname(): ?string;
    public function setCus_lastname(?string $value);

    public function getCus_email(): ?string;
    public function setCus_email(?string $value);

    public function getCus_birthdate(): ?DateTime;
    public function setCus_birthdate(?DateTime $value);

    public function getCus_city(): ?string;
    public function setCus_city(?string $value);
}
