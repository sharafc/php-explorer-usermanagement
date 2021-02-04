<?php

class Customer implements CustomerInterface
{
    private ?int $cus_id;
    private ?string $cus_firstname;
    private ?string $cus_lastname;
    private ?string $cus_email;
    private ?DateTime $cus_birthdate;
    private ?string $cus_city;

    public function __construct(
        ?int $id,
        ?string $firstname = NULL,
        ?string $lastname = NULL,
        ?string $email = NULL,
        ?DateTime $birthdate = NULL,
        ?string $city = NULL
    ) {
        $this->setCus_firstname($firstname);
        $this->setCus_lastname($lastname);
        $this->setCus_email($email);
        $this->setCus_birthdate($birthdate);
        $this->setCus_city($city);
        $this->setCus_id($id);

        logger('Constructor called', __CLASS__, LOGGER_INFO);
    }

    /**
     * Fetch all Customers from the database and create the correpsonding objects
     *
     * @param PDO $pdo The PDO object
     * @return array|null Array of customers if we found something in the db or null
     */
    public static function fetchAllCustomersFromDb(PDO $pdo): ?array
    {
        $query = 'SELECT * FROM customer';
        $statement = $pdo->prepare($query);
        $statement->execute();
        if ($statement->errorInfo()[2]) {
            logger('Something went wrong while saving Artist', $statement->errorInfo()[2]);
        }

        while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
            if(isset($result['cus_birthdate'])) {
                $date = new DateTime($result['cus_birthdate']);
            } else {
                $date = NULL;
            }

            $customers[] = new Customer(
                $result['cus_id'],
                $result['cus_firstname'],
                $result['cus_lastname'],
                $result['cus_email'],
                $date,
                $result['cus_city']
            );
        }

        return $customers ?? NULL;
    }

    /**
     * Save a customer to the database
     *
     * @param $pdo The PDO object
     * @return boolean true|false Returns true when the customer was saved successfully otherwise false
     */
    public function saveToDb(PDO $pdo): bool
    {
        $query = 'INSERT INTO customer
                  (cus_firstname, cus_lastname, cus_email, cus_birthdate, cus_city)
                  VALUES
                  (:ph_firstname, :ph_lastname, :ph_email, :ph_birthdate, :ph_city)';

        $map = [
            'ph_firstname' => $this->getCus_firstname(),
            'ph_lastname' => $this->getCus_lastname(),
            'ph_email' => $this->getCus_email(),
            'ph_birthdate' => ($this->getCus_birthdate() ? $this->getCus_birthdate()->format('Y-m-d') : NULL),
            'ph_city' => $this->getCus_city()
        ];

        $statement = $pdo->prepare($query);
        $statement->execute($map);
        if($statement->errorInfo()[2]) {
            logger('Something went wrong while saving customer', $statement->errorInfo()[2]);
        }

        $rowCount = $statement->rowCount();
        if ($rowCount) {
            $lastInsertId = $pdo->lastInsertId();
            $this->setCus_id($lastInsertId);
            logger('Saving successful. Customer saved with ID: ',$lastInsertId, LOGGER_INFO);

            return true;
        } else {
            logger('Saving of customer failed');
        }

        return false;
    }

    /**
     * Fetch existing customer values from the database
     *
     * @param $pdo The PDO object
     * @return boolean true|false Returns true when the customer data was fetched otherwise false
     */
    public function fetchFromDb(PDO $pdo): bool
    {
        $query = 'SELECT * FROM customer WHERE cus_id = :ph_id';
        $map = [
            'ph_id' => $this->getCus_id()
        ];
        $statement = $pdo->prepare($query);
        $statement->execute($map);
        if ($statement->errorInfo()[2]) {
            logger('Something went wrong while saving customer', $statement->errorInfo()[2]);
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->setCus_firstname($row['cus_firstname']);
            $this->setCus_lastname($row['cus_lastname']);
            $this->setCus_email($row['cus_email']);
            $this->setCus_birthdate($row['cus_birthdate']);
            $this->setCus_city($row['cus_city']);

            return true;
        }

        return false;
    }

    /**
     * Update an existing customer in the database
     *
     * @param $pdo The PDO object
     * @return boolean true|false Returns true when the customer was updated successfully otherwise false
     */
    public function updateToDb(PDO $pdo): bool
    {
        $query = 'UPDATE customer
                  SET
                  cus_firstname = :ph_firstname,
                  cus_lastname = :ph_lastname,
                  cus_email = :ph_email,
                  cus_birthdate = :ph_birthdate,
                  cus_city = :ph_city
                  WHERE cus_id = :ph_id';
        $map = [
            'ph_id' => $this->getCus_id(),
            'ph_firstname' => $this->getCus_firstname(),
            'ph_lastname' => $this->getCus_lastname(),
            'ph_email' => $this->getCus_email(),
            'ph_birthdate' => ($this->getCus_birthdate() ? $this->getCus_birthdate()->format('Y-m-d') : NULL),
            'ph_city' => $this->getCus_city()
        ];

        $statement = $pdo->prepare($query);
        $statement->execute($map);
        if ($statement->errorInfo()[2]) {
            logger('Something went wrong while updating customer with ID: ' . $this->getCus_id(), $statement->errorInfo()[2]);
        }

        if ($statement->rowCount()) {
            return true;
        } else {
            logger('Updating of customer failed');
        }

        return false;
    }

    /**
     * Delete selected Customer from database
     *
     * @param PDO $pdo The PDO object
     * @return boolean true|false Returns true when the customer was deleted successfully otherwise false
     */
    public function deleteFromDb(PDO $pdo): bool
    {
        $query = 'DELETE FROM customer WHERE cus_id = ' . $this->getCus_id();
        $statement = $pdo->prepare($query);
        $statement->execute();
        if ($statement->errorInfo()[2]) {
            logger('Something went wrong while deleting Customer with ID: ' . $this->getCus_id(), $statement->errorInfo()[2]);
        }

        if ($statement->rowCount()) {
            return true;
        } else {
            logger('Deletion of customer failed');
        }

        return false;
    }

    /**
     * Check if email of customer already exists in the database
     *
     * @param PDO $pdo The PDO object
     * @return boolean true|false Returns true when the email already exists otherwise false
     */
    public function emailExistsInDb(PDO $pdo): bool
    {
        $query = 'SELECT COUNT(cus_email) FROM customer WHERE cus_email = :ph_mail';
        $map = [
            'ph_mail' => $this->getCus_email()
        ];
        $statement = $pdo->prepare($query);
        $statement->execute($map);
        if ($statement->errorInfo()[2]) {
            logger('Something went wrong while fetching Customer emails', $statement->errorInfo()[2]);
        }

        $count = $statement->fetchColumn();
        if ($count > 0) {
            return true;
        }

        return false;
    }

    /**
     * Returns the fully qualified name of a customer
     *
     * @return string The fully qualified name of the customer
     */
    public function getFullname(): string
    {
        return $this->getCus_firstname() . ' ' . $this->getCus_lastname();
    }

    /**
     * Get the value of cus_id
     */
    public function getCus_id(): ?int
    {
        return $this->cus_id;
    }

    /**
     * Set the value of cus_id
     *
     * @return  self
     */
    public function setCus_id(?int $cus_id)
    {
        $this->cus_id = $cus_id;

        return $this;
    }

    /**
     * Get the value of cus_firstname
     */
    public function getCus_firstname(): ?string
    {
        return $this->cus_firstname;
    }

    /**
     * Set the value of cus_firstname
     *
     * @return  self
     */
    public function setCus_firstname(?string $cus_firstname)
    {
        $this->cus_firstname = $cus_firstname;

        return $this;
    }

    /**
     * Get the value of cus_lastname
     */
    public function getCus_lastname(): ?string
    {
        return $this->cus_lastname;
    }

    /**
     * Set the value of cus_lastname
     *
     * @return  self
     */
    public function setCus_lastname(?string $cus_lastname)
    {
        $this->cus_lastname = $cus_lastname;

        return $this;
    }

    /**
     * Get the value of cus_email
     */
    public function getCus_email(): ?string
    {
        return $this->cus_email;
    }

    /**
     * Set the value of cus_email
     *
     * @return  self
     */
    public function setCus_email(?string $cus_email)
    {
        $this->cus_email = $cus_email;

        return $this;
    }

    /**
     * Get the value of cus_birthdate
     */
    public function getCus_birthdate(): ?DateTime
    {
        return $this->cus_birthdate;
    }

    /**
     * Set the value of cus_birthdate
     *
     * @return  self
     */
    public function setCus_birthdate(?DateTime $cus_birthdate)
    {
        $this->cus_birthdate = $cus_birthdate;

        return $this;
    }

    /**
     * Get the value of cus_city
     */
    public function getCus_city(): ?string
    {
        return $this->cus_city;
    }

    /**
     * Set the value of cus_city
     *
     * @return  self
     */
    public function setCus_city(?string $cus_city)
    {
        $this->cus_city = $cus_city;

        return $this;
    }
}
