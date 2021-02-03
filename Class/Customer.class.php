<?php

class Customer implements CustomerInterface
{
    private ?int $cus_id;
    private string $cus_firstname;
    private string $cus_lastname;
    private string $cus_email;
    private ?DateTime $cus_birthdate;
    private ?string $cus_city;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        ?DateTime $birthdate = NULL,
        ?string $city = NULL,
        ?int $id = NULL
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
            $customers[] = new Customer(
                $result['cus_firstname'],
                $result['cus_lastname'],
                $result['cus_email'],
                new DateTime(),
                $result['cus_city'],
                $result['cus_id']
            );
        }

        return $customers ?? NULL;
    }


    /**
     * Save a customer to the database
     *
     * @param PDO $pdo
     * @return boolean true|false Returns true when the customer was saved successfully otherwise false
     */
    public function saveToDb(PDO $pdo)
    {
        $query = 'INSERT INTO customer
                  (cus_firstname, cus_lastname, $cus_email, $cus_birthdate, $cus_city)
                  VALUES
                  (:ph_firstname, :ph_lastname, :ph_email, :ph_birthdate, :ph_city)';

        $map = [
            'ph_firstname' => $this->getCus_firstname(),
            'ph_lastname' => $this->getCus_lastname(),
            'ph_email' => $this->getCus_email(),
            'ph_birthdate' => $this->getCus_birthdate(),
            'ph_city' => $this->getCus_city()
        ];

        $statement = $pdo->prepare($query);
        $statement->execute($map);
        if($statement->errorInfo()[2]) {
            logger('Something went wrong while saving customer');
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

    public function fetchFromDb(PDO $pdo)
    {
    }

    public function updateToDb(PDO $pdo)
    {
    }

    public function deleteFromDb(PDO $pdo)
    {
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
    public function getCus_id(): int
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
    public function getCus_firstname(): string
    {
        return $this->cus_firstname;
    }

    /**
     * Set the value of cus_firstname
     *
     * @return  self
     */
    public function setCus_firstname(string $cus_firstname)
    {
        $this->cus_firstname = $cus_firstname;

        return $this;
    }

    /**
     * Get the value of cus_lastname
     */
    public function getCus_lastname(): string
    {
        return $this->cus_lastname;
    }

    /**
     * Set the value of cus_lastname
     *
     * @return  self
     */
    public function setCus_lastname(string $cus_lastname)
    {
        $this->cus_lastname = $cus_lastname;

        return $this;
    }

    /**
     * Get the value of cus_email
     */
    public function getCus_email(): string
    {
        return $this->cus_email;
    }

    /**
     * Set the value of cus_email
     *
     * @return  self
     */
    public function setCus_email(string $cus_email)
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
