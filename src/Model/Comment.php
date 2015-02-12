<?php

namespace Masterclass\Model;

use Masterclass\Dbal\AbstractDb;

/**
 * Description of Content
 *
 * @author cainmartin
 */
class Comment
{
    /**
     *
     * @var AbstractDb 
     */
    protected $db;
    
    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }   
    
    public function getStoryComments($storyId)
    {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $comments = $this->db->fetchAll($comment_sql, [$storyId]);
        
        return $comments;
    }
    
    public function createComment($username, $storyid, $comment)
    {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        return $this->db->execute($sql, array(
            $username,
            $storyid,
            filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ));
    }
}
