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
     * Creates user's model from database's row.
     *
     * @param array $row  Row from database's table.
     *
     * @return User  User's instance.
     */
    public static function fromRow(array $row): User
    {
        $instance = new User(
            $row['login'],
            $row['email'],
            $row['password_hash']
        );

        $instance->id = $row['id'];
        $instance->createdAt = $row['created_at'];

        return $instance;
    }

    /**
     * Finds user in the database by login and creates it's model.
     *
     * @param string $login  User's login.
     *
     * @return ?User  User's instance if found, else null.
     */
    public static function findByLogin(string $login): ?User
    {
        $dummy = new User('');
        $db = $dummy->initMySQL()->getConnection();

		$stmt = $db->prepare(
            'SELECT *
            FROM `users`
			WHERE `login` = ?
			LIMIT 1'
        );

		$stmt->execute([$login]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? static::fromRow($row) : null;
    }

    /**
     * Creates user's model without saving it in the database.
     *
     * @param string $login  User's login.
     * @param string $email  User's email.
     * @param string $passwordHash  User password's hash.
     */
    public function __construct(
        string $login, string $email = '', string $passwordHash = ''
    ) {
        $this->login = $login;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    /**
     * Calculates password's hash and sets it in the user's model.
     * Does not save it in the database.
     *
     * @param string $password  User's new password.
     *
     * @return User  This user's instance.
     */
    public function setPassword(string $password): User
    {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Registers this user in the database.
     *
     * @throws \RuntimeException  If this user is already in the database.
     *
     * @return User  This user's instance.
     */
    public function register(): User
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

    /**
     * Verifies if specified password is correct.
     *
     * @param string $password  Specified password.
     *
     * @return bool  Is $password correct.
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }
}
