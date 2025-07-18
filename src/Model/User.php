<?php

namespace Chat\Model;


/**
 * User's model.
 */
class User
{
    use \Chat\Inject\MySQL;


    /**
     * User's identifier in the database.
     *
     * @var int
     */
    public $id;

    /**
     * User's login in the database.
     *
     * @var string
     */
    public $login;

    /**
     * User's e-mail in the database.
     *
     * @var string
     */
    public $email;

    /**
     * User password's hash in the database.
     *
     * @var string
     */
    public $passwordHash;

    /**
     * User's creation date as 'Y-m-d H:i:s' string.
     *
     * @var string
     */
    public $createdAt;


    /**
     * Creates user's model without saving it in the database.
     *
     * @param string $login  User's login.
     * @param string $email  User's email.
     * @param string $passwordHash  User password's hash.
     */
    public function __construct(
        string $login, string $email, string $passwordHash
    ) {
        $this->login = $login;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    /**
     * Saves this user in the database.
     *
     * @throws \RuntimeException  If this user is already in the database.
     *
     * @return User  This user's instance.
     */
    public function save(): User
    {
        if ($this->id !== null) {
            $text = sprintf('User %d is already in the database.', $this->id);
            throw new \RuntimeException($text);
        }

        $db = $this->initMySQL()->getConnection();

		$stmt = $db->prepare(
            'INSERT INTO `users` (`login`, `email`, `password_hash`, `created_at`)
            VALUES (?, ?, ?, ?)'
        );

		$stmt->execute([
            $this->login,
			$this->email,
			$this->passwordHash,
			$this->createdAt,
		]);

        $this->id = $db->lastInsertId();
        return $this;
    }
}
