<?php

namespace ch\comem\todoapp\auth;

require_once(__DIR__ . "/../../../../../vendor/autoload.php");

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Exception;

/**
 * Represents a user in the Todo app.
 * 
 * @package ch\comem\todoapp\auth
 */
class User
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

    public function setPassword(string $password): void
    {
        if (!$password || !is_string($password)) throw new Exception('Password must be defined and of type string');
        if (password_get_info($password)['algo'] === 0) throw new Exception('Password must be hashed');

        $this->password = $password;
    }

    public function resetPassword(): bool
    {
        if ($this->getId() === null) throw new Exception('User must be saved in the database before resetting password');

        $tokenLength = 32;
        $tokenExpire = time() + 3600; // 1 hour

        $resertPasswordToken = bin2hex(random_bytes($tokenLength));
        $timestamp = date('Y-m-d H:i:s', $tokenExpire);

        $sql = "UPDATE User SET password_token = :password_token, password_token_expire = :password_token_expire WHERE id = :id";
        $stmt = DbManagerCRUD_User::getInstance()->getDb()->prepare($sql);
        $stmt->execute([
            ':password_token' => $resertPasswordToken,
            ':password_token_expire' => $timestamp,
            ':id' => $this->getId()
        ]);

        // @TODO: Send email to user with link to reset password
        $result = false;
        $transport = Transport::fromDsn('smtp://host.docker.internal:1025');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('no-reply@todoapp.ch')
            ->to($this->getEmail())
            ->subject('Reset password procedure')
            ->text('Please click on the following link to reset your password: http://localhost/reset-password.php?token=' . $resertPasswordToken)
            ->html('<h1>Reset password procedure</h1><p>Please click on the following link to reset your password: <a href="http://localhost/reset-password.php?token=' . $resertPasswordToken . '">Reset password</a></p>');
        try {
            $mailer->send($email);
            $result = true;
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
        return $result;
    }
}
