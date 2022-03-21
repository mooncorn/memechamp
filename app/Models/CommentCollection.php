<?php

namespace App\Models;

use App\Helpers\Routing;
use Exception;
use PDO;

class CommentCollection
{
    private array $comments;

    private int $indentation;

    public function __construct(int $indentation = 0)
    {
        $this->comments = array();
        $this->indentation = $indentation;
    }

    public function load(PDO $pdo, string $index, int $value)
    {
        $identifier = strtolower($index);

        if ($identifier == 'post_id') {
            $sql = "SELECT id FROM comment WHERE post_id=$value AND reply_to_id IS NULL";
        } else if ($identifier == 'reply_to_id' || $identifier == 'owner_id') {
            $sql = "SELECT id FROM comment WHERE $identifier=$value";
        } else {
            throw new Exception('Invalid index. Must be reply_to_id, post_id or owner_id.');
        }

        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch()) {
            $comment = new Comment($this->indentation + 1);
            $comment->load($pdo, $row['id']);
            $this->comments[] = $comment;
        }
    }

    /*
     * return [
     *  ['indent'=>int, 'owner_username'=>string, 'created_at'=>string, 'content'=>string],
     *  ...
     * ]
     */
    public static function formatForDisplay(CommentCollection $commentCollection) {

    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @return int
     */
    public function getIndentation(): int
    {
        return $this->indentation;
    }

    /**
     * @param int $indentation
     */
    public function setIndentation(int $indentation): void
    {
        $this->indentation = $indentation;
    }
}