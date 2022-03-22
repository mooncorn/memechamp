<?php

namespace App\Models;

use Exception;
use PDO;

class Like
{
    public static function create(PDO $pdo, int $user_id, int $comment_id): bool
    {
        try
        {
            $stmt = $pdo->prepare("INSERT INTO comment_like (user_id, comment_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $comment_id]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function delete(PDO $pdo, int $user_id, int $comment_id): bool
    {
        try
        {
            $stmt = $pdo->prepare("DELETE FROM comment_like WHERE user_id = ? AND comment_id = ?");
            $stmt->execute([$user_id, $comment_id]);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function exists(PDO $pdo, int $user_id, int $comment_id): bool
    {
        return (bool) $pdo->query("SELECT id FROM comment_like WHERE user_id = $user_id AND comment_id = $comment_id")->fetch();
    }

    public static function getNumberOfLikesForComment(PDO $pdo, $comment_id): int
    {
        $result = $pdo->query("SELECT id FROM comment_like WHERE comment_id = $comment_id")->fetchAll();
        return count($result);
    }
}