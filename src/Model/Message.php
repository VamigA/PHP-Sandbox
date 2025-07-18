<?php

namespace Chat\Model;


/**
 * Message's model.
 */
class Message
{
    use \Chat\Inject\MySQL;


    /**
     * Message's identifier in the database.
     *
     * @var int
     */
    public $id;

    /**
     * Message's chat identifier in the database.
     *
     * @var int
     */
    public $chatId;

    /**
     * Message's sender identifier in the database.
     *
     * @var int
     */
    public $senderId;

    /**
     * Message's body.
     *
     * @var string
     */
    public $body;

    /**
     * Message's creation date as 'Y-m-d H:i:s' string.
     *
     * @var string
     */
    public $createdAt;


    /**
     * Creates message's model from database's row.
     *
     * @return Message  Message's instance.
     */
    public static function fromRow(array $row): Message
    {
        $instance = new Message(
            $row['chat_id'],
            $row['sender_id'],
            $row['body']
        );

        $instance->id = $row['id'];
        $instance->createdAt = $row['created_at'];

        return $instance;
    }

    /**
     * Creates message's model without saving it in the database.
     *
     * @param int $chatId  Message's chat identifier in the database.
     * @param int $senderId  Message's sender identifier in the database.
     * @param string $body  Message's body.
     */
    public function __construct(int $chatId, int $senderId, string $body)
    {
        $this->chatId = $chatId;
        $this->senderId = $senderId;
        $this->body = $body;
        $this->createdAt = date('Y-m-d H:i:s');
    }

    /**
     * Saves this message in the database.
     *
     * @throws \RuntimeException  If this message is already in the database.
     *
     * @return Message  This message's instance.
     */
    public function save(): Message
    {
        if ($this->id !== null) {
            $text = sprintf('Message %d is already in the database.', $this->id);
            throw new \RuntimeException($text);
        }

        $db = $this->initMySQL()->getConnection();

		$stmt = $db->prepare(
            'INSERT INTO `messages` (`chat_id`, `sender_id`, `body`, `created_at`)
            VALUES (?, ?, ?, ?)'
        );

		$stmt->execute([
            $this->chatId,
			$this->senderId,
			$this->body,
			$this->createdAt,
		]);

        $this->id = $db->lastInsertId();
        return $this;
    }
}
