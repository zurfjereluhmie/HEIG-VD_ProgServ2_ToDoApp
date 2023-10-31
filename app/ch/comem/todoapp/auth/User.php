<?php

namespace ch\comem\todoapp\auth;

use Exception;

/**
 * Represents a user in the Todo app.
 * 
 * @package ch\comem\todoapp\auth
 */
final class User
{
    /**
     * @var int $id The user's unique identifier.
     */
    private $id;
    /**
     * @var string $email The email of the user.
     */
    private $email;
    /**
     * @var string $password The password of the user.
     */
    private $password;
    /**
     * @var string $firstName The first name of the user.
     */
    private $firstName;
    /**
     * @var string $lastName The last name of the user.
     */
    private $lastName;

    /**
     * User constructor.
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param int|null $id The id of the user. Should only be used when retrieving the user from the database.
     */
    public function __construct($email, $password, $firstName, $lastName, $id = null)
    {
        if (!$email || !is_string($email)) throw new Exception('Email must be defined and of type string');
        if (!$password || !is_string($password)) throw new Exception('Password must be defined and of type string');
        if (!$firstName || !is_string($firstName)) throw new Exception('First name must be defined and of type string');
        if (!$lastName || !is_string($lastName)) throw new Exception('Last name must be defined and of type string');

        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->id = $id;
    }

    /**
     * Get the id of the user. If the user has not been saved in the database yet, the id will be null.
     *
     * @return int The id of the user.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the email of the user.
     *
     * @return string The email of the user.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the password of the user.
     *
     * @return string The password of the user.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the first name of the user.
     *
     * @return string The first name of the user.
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Get the last name of the user.
     *
     * @return string The last name of the user.
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Sets the ID of the user. Should only be used when retrieving the user from the database.
     *
     * @param int $id The ID of the user.
     * @return void
     */
    public function setId(int $id): void
    {
        if (!$id) throw new Exception('Id must be defined and of type int');
        $this->id = $id;
    }
}
