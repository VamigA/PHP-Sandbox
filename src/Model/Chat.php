<?php

namespace Chat\Model;


/**
 * Chat's model.
 */
class Chat
{
    use \Chat\Inject\MySQL;


    /**
     * Chat's identifier in the database.
     *
     * @var int
     */
    public $id;

    /**
     * Chat's user 1 identifier in the database.
     *
     * @var int
     */
    public $userId1;

    /**
     * Chat's user 2 identifier in the database.
     *
     * @var int
     */
    public $userId2;

    /**
     * Chat's creation date as 'Y-m-d H:i:s' string.
     *
     * @var string
     */
    public $createdAt;


    /**
     * Creates chat's model without saving it in the database.
     *
     * @param int $userId1  Chat's user 1 identifier in the database.
     * @param int $userId2  Chat's user 2 identifier in the database.
     */
    public function __construct(int $userId1, int $userId2)
    {
		if($userId1 > $userId2)
			list($userId1, $userId2) = [$userId2, $userId1];

        $this->userId1 = $userId1;
        $this->userId2 = $userId2;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    /**
     * Saves this chat in the database.
     *
     * @throws \RuntimeException  If this chat is already in the database.
     *
     * @return Chat  This chat's instance.
     */
    public function save(): Chat
    {
        if ($this->id !== null) {
            $text = sprintf('Chat %d is already in the database.', $this->id);
            throw new \RuntimeException($text);
        }

        $db = $this->initMySQL()->getConnection();

		$stmt = $db->prepare(
            'INSERT INTO `chats` (`user_1_id`, `user_2_id`, `created_at`)
            VALUES (?, ?, ?)'
        );

		$stmt->execute([
            $this->userId1,
            $this->userId2,
			$this->createdAt,
		]);

        $this->id = $db->lastInsertId();
        return $this;
    }

    /**
     * Returns messages history in this chat.
     *
     * @return array  Array of Message instances.
     */
    public function getHistory(): array
    {
        if ($this->id === null) {
            throw new \RuntimeException('The chat is not saved in the database.');
        }

        $db = $this->initMySQL()->getConnection();

		$stmt = $db->prepare(
            'SELECT *
            FROM `messages`
			WHERE `chat_id` = ?
			ORDER BY `created_at` ASC'
        );

		$stmt->execute([$this->id]);

        $result = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = Message::fromRow($row);
        }

        return $result;
    }
}
