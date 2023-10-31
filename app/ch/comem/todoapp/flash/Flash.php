<?php

namespace ch\comem\todoapp\flash;

use Exception;

/**
 * This class represents a flash message. It can be used to display a message to the user on the next page load.
 * 
 * @package ch\comem\todoapp\flash
 */
class Flash
{
    /**
     * An array of strings representing the types of flash messages that can be displayed.
     * @var array<string>
     */
    private static $TYPES = ['success', 'info', 'warning', 'danger'];
    /**
     * @var string $name The name of the flash message.
     */
    private $name;
    /**
     * @property string $message The message to be displayed.
     */
    private $message;
    /**
     * @var string $type The type of flash message (success, error, warning, info)
     */
    private $type;

    /**
     * Flash constructor.
     * @param string $name The name of the flash message.
     * @param string $message The message of the flash message.
     * @param string $type The type of the flash message.
     */
    public function __construct($name, $message, $type)
    {
        if (!$name || !is_string($name)) throw new Exception('Name must be defined and of type string');
        if (!$message || !is_string($message)) throw new Exception('Message must be defined and of type string');
        if (!$type || !is_string($type)) throw new Exception('Type must be defined and of type string');
        if (!in_array($type, self::$TYPES)) throw new Exception('Type must be one of the following: ' . implode(', ', self::$TYPES));

        $this->name = $name;
        $this->message = $message;
        $this->type = $type;

        $this->setToSession();
    }

    /**
     * Sets the flash message to the session. If a flash message with the same name already exists, it is overwritten.
     *
     * @return void
     */
    private function setToSession(): void
    {
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['flash'])) $_SESSION['flash'] = [];
        if (isset($_SESSION['flash'][$this->name])) unset($_SESSION['flash'][$this->name]);

        $_SESSION['flash'][$this->name] = [
            'message' => $this->message,
            'type' => $this->type
        ];
    }

    /**
     * Formats the message of a flash message. It is formatted as a bootstrap alert.
     *
     * @param array $flash The flash message to format.
     * @return string The formatted message.
     */
    private static function formatMessage(array $flash): string
    {
        $msg = $flash['message'];
        $type = $flash['type'];
        $html = <<<html
        <div class="alert alert-$type alert-dismissible fade show" role="alert">
            $msg
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        html;
        return $html;
    }

    /**
     * Displays a flash message with the given name.
     *
     * @param string $name The name of the flash message to display.
     * @return void
     */
    public static function displayFlashMessage(string $name): void
    {
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION['flash'][$name])) {
            $flash = $_SESSION['flash'][$name];
            unset($_SESSION['flash'][$name]);
            echo self::formatMessage($flash);
        }
    }

    /**
     * Displays all flash messages stored in the session.
     *
     * @return void
     */
    public static function displayAllFlashMessages(): void
    {
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION['flash'])) return;

        foreach ($_SESSION['flash'] as $name => $flash) {
            unset($_SESSION['flash'][$name]);
            echo self::formatMessage($flash);
        }
    }
}
