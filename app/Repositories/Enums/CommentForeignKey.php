<?php

namespace App\Repositories\Enums;

enum CommentForeignKey: string {
    case POST_ID = 'post_id';
    case REPLY_TO_ID = 'reply_to_id';
    case OWNER_ID = 'owner_id';
}