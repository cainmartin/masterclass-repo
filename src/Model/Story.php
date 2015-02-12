<?php

namespace Masterclass\Model;

use Masterclass\Dbal\AbstractDb;

/**
 * Description of Story
 *
 * @author cainmartin
 */
class Story
{
    /**
     * @var AbstractDb
     */
    protected $db;
    
    /**
     * 
     * @param type $config
     */
    public function __construct(AbstractDb $db)
    {       
        $this->db = $db; 
    }
    
    /**
     * 
     * @return type
     */
    public function getAllStories()
    {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        
        $stories = $this->db->fetchAll($sql);
        
        foreach($stories as $key => $story) {
            $comment_sql = 'SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?';
            $count = $this->db->fetchOne($comment_sql, [$story['id']]);
            $stories[$key]['count'] = $count['count'];
        }
        
        return $stories;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getStory($id)
    {
        $story_sql = 'SELECT * FROM story WHERE id = ?';
        $story = $this->db->fetchOne($story_sql, [$id]);
        
        return $story;
    }
    
    public function createStory($headline, $url, $username)
    {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $this->db->execute($sql, array(
           $headline,
           $url,
           filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ));
        
        return $this->db->lastInsertId();
    }
}
