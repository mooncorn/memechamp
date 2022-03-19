<?php

namespace App\Models;

class Comment
{
    private int $id;
    private string $content;
    private int $owner_id;
    private int|null $reply_to_id;
    private int $post_id;
    private string $created_at;

    private CommentCollection $replies; // an array of comments

    public function __construct(int $indentation = 0)
    {
        $this->id = 0;
        $this->content = "";
        $this->owner_id = 0;
        $this->reply_to_id = null;
        $this->post_id = 0;
        $this->created_at = "";
        $this->replies = new CommentCollection($indentation);
    }

    public function load(int $id): ?Comment
    {
        global $db;
        $sql = "SELECT * FROM comment WHERE id=$id";

        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $this->id = $row["id"];
            $this->content = $row["content"];
            $this->owner_id = $row['owner_id'];
            $this->reply_to_id = $row["reply_to_id"];
            $this->post_id = $row["post_id"];
            $this->created_at = $row["created_at"];

            // every comment will load its own replies
            $this->loadReplies();

            return $this;
        }

        return null;
    }

    public function save(): ?Comment {
        global $db;

        // if comment already has an id, update existing comment
        if ($this->isLoaded()) {
            $sql = "UPDATE comment SET 
                content='$this->content'
                WHERE id=$this->id";
        }
        // if comment does not have an id, insert new comment
        else {
            $sql = "INSERT INTO comment (content, reply_to_id, post_id)
                    VALUES ('$this->content', '$this->reply_to_id', '$this->post_id')";
        }

        mysqli_query($db, $sql);
        if ($this->load($this->id)) {
            return $this;
        } else {
            return null;
        }
    }

    public function isLoaded(): bool {
        return $this->id != 0;
    }

    public function loadReplies()
    {
        $this->replies->load('reply_to_id', $this->id);
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
     * @param CommentCollection $replies
     */
    public function setReplies(CommentCollection $replies): void
    {
        $this->replies = $replies;
    }

    /**
     * @return CommentCollection
     */
    public function getReplies(): CommentCollection
    {
        return $this->replies;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    /**
     * @param int $owner_id
     */
    public function setOwnerId(int $owner_id): void
    {
        $this->owner_id = $owner_id;
    }

    public function getOwner(): User
    {
        $owner = new User();
        $owner->load('id', $this->owner_id);
        return $owner;
    }


    #endregion
}