<?php

namespace Chat\Service;

use \Chat\Database;
use \Chat\Model\Message;

class MessageService
{
	public function create(Message $message): void
	{
		$stmt = Database::get()->prepare('INSERT INTO messages
			(sender_id, receiver_id, body, created_at) VALUES (?, ?, ?, ?)');

		$stmt->execute([
			$message->senderId,
			$message->receiverId,
			$message->body,
			$message->createdAt,
		]);
	}

	public function getHistory(int $user1, int $user2): array
	{
		$stmt = Database::get()->prepare('SELECT * FROM messages
			WHERE sender_id = ? AND receiver_id = ?
				OR receiver_id = ? AND sender_id = ?
			ORDER BY created_at ASC');

		$stmt->execute([$user1, $user2, $user1, $user2]);
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
