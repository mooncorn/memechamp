<?php

namespace App\Models;

use Exception;

class CommentCollection
{
    private array $comments;

    private int $indentation;

    public function __construct(int $indentation = 0)
    {
        $this->comments = array();
        $this->indentation = $indentation;
    }

    public function load(string $index, int $value)
    {
        global $db;
        $identifier = strtolower($index);

        if ($identifier == 'post_id') {
            $sql = "SELECT id FROM comment WHERE post_id=$value AND reply_to_id IS NULL";
        } else if ($identifier == 'reply_to_id' || $identifier == 'owner_id') {
            $sql = "SELECT id FROM comment WHERE $identifier=$value";
        } else {
            throw new Exception('Invalid index. Must be reply_to_id, post_id or owner_id.');
        }

        $result = mysqli_query($db, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $comment = new Comment($this->indentation + 1);
            $comment->load($row['id']);
            $this->comments[] = $comment;
        }
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