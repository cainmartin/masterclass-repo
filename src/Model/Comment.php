<?php

namespace Masterclass\Model;

use PDO;

/**
 * Description of Content
 *
 * @author cainmartin
 */
class Comment
{
    protected $db;
    
    public function __construct(PDO $pdo)
    {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
    }   
    
    public function getStoryComments($storyId)
    {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comment_stmt = $this->db->prepare($comment_sql);
        $comment_stmt->execute(array($storyId));
        $comments = $comment_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $comments;
    }
    
    public function createComment($username, $storyid, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            $username,
            $storyid,
            filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ));
    }
}
