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
     * @var bool $isValid Indicates if the has validated his account.
     */
    private $isValid;

    /**
     * User constructor.
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     * @param string $firstName The first name of the user.
     * @param string $lastName The last name of the user.
     * @param bool $isValid Indicates if the has validated his account.
     * @param int|null $id The id of the user. Should only be used when retrieving the user from the database.
     */
    public function __construct($email, $password, $firstName, $lastName, $isValid, $id = null)
    {
        if (!$email || !is_string($email)) throw new Exception('Email must be defined and of type string');
        if (!$password || !is_string($password)) throw new Exception('Password must be defined and of type string');
        if (!$firstName || !is_string($firstName)) throw new Exception('First name must be defined and of type string');
        if (!$lastName || !is_string($lastName)) throw new Exception('Last name must be defined and of type string');
        if (!is_bool($isValid)) throw new Exception('isValid must be defined and of type bool');

        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->isValid = $isValid;
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
     * Get the validation status of the user.
     *
     * @return bool
     */
    public function getIsValid(): bool
    {
        return $this->isValid;
    }

    /**
     * Sets the ID of the user.
     * Should only be used when retrieving the user from the database.
     *
     * @param int $id The ID of the user.
     * @return void
     */
    public function setId(int $id): void
    {
        if (!$id) throw new Exception('Id must be defined and of type int');
        $this->id = $id;
    }

    /**
     * Sets the last name of the user.
     *
     * @param string $lastName The last name of the user.
     * @return void
     */
    public function setLastName(string $lastName): void
    {
        if (!$lastName || !is_string($lastName)) throw new Exception('Last name must be defined and of type string');
        $this->lastName = $lastName;
    }

    /**
     * Sets the first name of the user.
     *
     * @param string $firstName The first name of the user.
     * @return void
     */
    public function setFirstName(string $firstName): void
    {
        if (!$firstName || !is_string($firstName)) throw new Exception('First name must be defined and of type string');
        $this->firstName = $firstName;
    }

    /**
     * Sets the password for the user.
     * Only accepts hashed passwords.
     *
     * @param string $password The hash of the password to set.
     * @return void
     */
    public function setPassword(string $password): void
    {
        if (!$password || !is_string($password)) throw new Exception('Password must be defined and of type string');
        if (!password_get_info($password)['algo']) throw new Exception('Password must be hashed');

        $this->password = $password;
    }

    /**
     * Sets the validity of the user. Should only be used when validating the user's account trough token.
     *
     * @param bool $isValid The validity of the user.
     * @return void
     */
    public function setIsValid(bool $isValid): void
    {
        if (!is_bool($isValid)) throw new Exception('isValid must be defined and of type bool');
        $this->isValid = $isValid;
    }

    /**
     * Create a token to reset the user's password and send it to them by email.
     *
     * @return bool True if the token and email were sent successfully, false otherwise.
     */
    public function resetPassword(): bool
    {
        if (!$this->getId()) throw new Exception('User must be saved in the database before resetting password');

        $tokenExpire = time() + 3600; // 1 hour
        $timestamp = date('Y-m-d H:i:s', $tokenExpire);

        $resertPasswordToken = $this->generateToken();

        $sql = "UPDATE User SET password_token = :password_token, password_token_expire = :password_token_expire WHERE id = :id";
        $stmt = DbManagerCRUD_User::getInstance()->getDb()->prepare($sql);
        $result = $stmt->execute([
            ':password_token' => $resertPasswordToken,
            ':password_token_expire' => $timestamp,
            ':id' => $this->getId()
        ]);

        if (!$result) return false;

        $result = false;
        $transport = Transport::fromDsn('smtp://host.docker.internal:1025');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('no-reply@todoapp.ch')
            ->to($this->getEmail())
            ->subject('Reset password procedure')
            ->text('Please click on the following link to reset your password: http://localhost/reset-password.php?token=' . $resertPasswordToken)
            ->html('<h1>Reset password procedure</h1><p>Please click on the following link to reset your password: <a href="http://localhost/reset-password.php?token=' . $resertPasswordToken . '">Reset password</a></p><br><p>Note: this link will expire in 1 hour.</p>');
        try {
            $mailer->send($email);
            $result = true;
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    /**
     * Sends a validation email to the user.
     *
     * @return bool True if the email was sent successfully, false otherwise.
     */
    public function sendValidationEmail(): bool
    {
        if (!$this->getId()) throw new Exception('User must be saved in the database before resetting password');

        $validateToken = $this->generateToken();

        $sql = "UPDATE User SET validate_token = :validateToken WHERE id = :id";
        $stmt = DbManagerCRUD_User::getInstance()->getDb()->prepare($sql);
        $result = $stmt->execute([
            ':validateToken' => $validateToken,
            ':id' => $this->getId()
        ]);

        if (!$result) return false;

        $result = false;
        $transport = Transport::fromDsn('smtp://host.docker.internal:1025');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('no-reply@todoapp.ch')
            ->to($this->getEmail())
            ->subject('Validate your account')
            ->text('Please click on the following link to validate your account: http://localhost/validate-account.php?token=' . $validateToken)
            ->html('<h1>Validate your account</h1><p>Please click on the following link to validate your account: <a href="http://localhost/validate-account.php?token=' . $validateToken . '">Validate account</a></p>');
        try {
            $mailer->send($email);
            $result = true;
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    /**
     * Generates a token for the user.
     *
     * @return string The generated token.
     */
    private function generateToken(): string
    {
        $tokenLength = 32;
        return bin2hex(random_bytes($tokenLength));
    }
}
