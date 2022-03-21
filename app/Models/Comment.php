<?php

namespace App\Models;

use Exception;
use PDO;

class Comment
{
    private int $id;
    private string $content;
    private int|null $owner_id;
    private int|null $reply_to_id;
    private int $post_id;
    private bool $deleted;
    private bool $edited;
    private string $created_at;

    public function __construct()
    {
        $this->id = 0;
        $this->content = "";
        $this->owner_id = null;
        $this->reply_to_id = null;
        $this->post_id = 0;
        $this->deleted = false;
        $this->edited = false;
        $this->created_at = "";
    }

    /**
     * Queries the database for a record with specified id and
     * updates the properties of the class with found data.
     *
     * @param PDO $pdo Connection to database
     * @param int $id The id of database row that needs to be fetched and loaded
     *
     * @author David Pilarski
     * @return Comment|null Returns an instance of Comment if record is found, otherwise returns null.
     */
    public function load(PDO $pdo, int $id): ?Comment
    {
        $row = $pdo->query("SELECT * FROM comment WHERE id=$id")->fetch();

        if (!$row) return null;

        $this->id = $row["id"];
        $this->content = $row["content"];
        $this->owner_id = $row['owner_id'];
        $this->reply_to_id = $row["reply_to_id"];
        $this->post_id = $row["post_id"];
        $this->deleted = $row['deleted'];
        $this->edited = $row['edited'];
        $this->created_at = $row["created_at"];
        return $this;
    }

    /**
     * Will either save or update current instance of Comment.
     * If id is present, the method will update an existing record in database.
     * If id is missing, a new record will be inserted into the database.
     *
     * @param PDO $pdo Connection to database
     *
     * @author David Pilarski
     * @return Comment|null Returns an instance of Comment if record is successfully updated or inserted, otherwise returns null.
     */
    public function save(PDO $pdo): ?Comment
    {
        try
        {
            if ($this->id != 0)
            {
                $stmt = $pdo->prepare("UPDATE comment SET content=?,deleted=?,edited='true' WHERE id=?");
                $stmt->execute([$this->content, $this->deleted, $this->id]);
            }
            else
            {
                $stmt = $pdo->prepare("INSERT INTO comment (content, reply_to_id, post_id, owner_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$this->content, $this->reply_to_id, $this->post_id, $this->owner_id]);
            }

            return $this->load($pdo, $this->id);
        }
        catch (Exception $e)
        {
            return null;
        }
    }

    /**
     * Queries the database for a list of records that match with the value of foreign key.
     *
     * @param PDO $pdo Connection to database
     * @param string $foreign_key The name of the foreign key in database
     * @param int $value The value of foreign key
     *
     * @return array of Comment objects
     * @throws Exception If foreign key is not 'reply_to_id', 'post_id' or 'owner_id', an Exception is thrown.
     * @author David Pilarski
     */
    public static function fetchComments(PDO $pdo, string $foreign_key, int $value): array
    {
        $comments = [];
        $identifier = strtolower($foreign_key);

        if ($identifier == 'post_id')
        {
            $sql = "SELECT id FROM comment WHERE post_id=$value AND reply_to_id IS NULL";
        }
        else if ($identifier == 'reply_to_id' || $identifier == 'owner_id')
        {
            $sql = "SELECT id FROM comment WHERE $identifier=$value";
        }
        else
        {
            throw new Exception('Invalid index. Must be reply_to_id, post_id or owner_id.');
        }

        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch())
        {
            $comment = new Comment();
            $comment->load($pdo, $row['id']);
            $comments[] = $comment;
        }

        return $comments;
    }

    /**
     * Queries the database for a list of records that match with the value of foreign key, and
     * fetches the owner for every comment.
     *
     * @param PDO $pdo Connection to database
     * @param string $foreign_key The name of the foreign key in database
     * @param int $value The value of foreign key
     *
     * @return array [[Comment, User], ... ]
     * @throws Exception If foreign key is not 'reply_to_id', 'post_id' or 'owner_id', an Exception is thrown.
     * @author David Pilarski
     */
    public static function fetchCommentsWithOwner(PDO $pdo, string $foreign_key, int $value): array
    {
        $commentsWithOwner = [];
        $identifier = strtolower($foreign_key);

        if ($identifier == 'post_id')
        {
            $sql = "SELECT id FROM comment WHERE post_id=$value AND reply_to_id IS NULL";
        }
        else if ($identifier == 'reply_to_id' || $identifier == 'owner_id')
        {
            $sql = "SELECT id FROM comment WHERE $identifier=$value";
        }
        else
        {
            throw new Exception('Invalid index. Must be reply_to_id, post_id or owner_id.');
        }

        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch())
        {
            $comment = new Comment();
            $user = new User();

            $comment->load($pdo, $row['id']);
            $user->load($pdo, 'id', $comment->getOwnerId());

            $commentsWithOwner[] = ['Comment'=>$comment, 'User'=>$user];
        }

        return $commentsWithOwner;
    }

    /**
     * Queries the database for a list of records that match with the value of foreign key.
     * Fetches the owner and replies for every comment.
     *
     * @param PDO $pdo Connection to database
     * @param string $foreign_key The name of the foreign key in database
     * @param int $value The value of foreign key
     *
     * @return array [[Comment, User, Replies], ... ]
     * @throws Exception If foreign key is not 'reply_to_id', 'post_id' or 'owner_id', an Exception is thrown.
     * @author David Pilarski
     */
    public static function fetchCommentsWithOwnerAndReplies(PDO $pdo, string $foreign_key, int $value): array
    {
        $commentsWithOwnerAndReplies = [];
        $identifier = strtolower($foreign_key);

        if ($identifier == 'post_id')
        {
            $sql = "SELECT id FROM comment WHERE post_id=$value AND reply_to_id IS NULL";
        }
        else if ($identifier == 'reply_to_id' || $identifier == 'owner_id')
        {
            $sql = "SELECT id FROM comment WHERE $identifier=$value";
        }
        else
        {
            throw new Exception('Invalid index. Must be reply_to_id, post_id or owner_id.');
        }

        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch())
        {
            $comment = new Comment();
            $comment->load($pdo, $row['id']);

            $user = new User();
            $user->load($pdo, 'id', $comment->getOwnerId());

            $replies = Comment::fetchComments($pdo, 'reply_to_id', $comment->getId());

            $commentsWithOwnerAndReplies[] = ['Comment'=>$comment, 'User'=>$user, 'Replies'=>$replies];
        }

        return $commentsWithOwnerAndReplies;
    }

    /**
     * Queries the database for the owner of the comment.
     *
     * @param PDO $pdo Connection to database
     *
     * @throws Exception is thrown when invalid uniqueIdentifierName is provided into the load method
     * @author David Pilarski
     * @return User|null The owner of the comment
     */
    public function fetchOwner(PDO $pdo): ?User
    {
        $owner = new User();
        return $owner->load($pdo, 'id', $this->owner_id);
    }

    #region Getters & Setters
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int|null
     */
    public function getReplyToId(): int|null
    {
        return $this->reply_to_id;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @param int|null $reply_to_id
     */
    public function setReplyToId(int|null $reply_to_id): void
    {
        $this->reply_to_id = $reply_to_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return int|null
     */
    public function getOwnerId(): int|null
    {
        return $this->owner_id;
    }

    /**
     * @param int|null $owner_id
     */
    public function setOwnerId(int|null $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isEdited(): bool
    {
        return $this->edited;
    }

    /**
     * @param bool $edited
     */
    public function setEdited(bool $edited): void
    {
        $this->edited = $edited;
    }
    #endregion
}