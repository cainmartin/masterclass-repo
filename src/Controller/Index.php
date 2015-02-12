<?php
 
namespace Masterclass\Controller;

use Masterclass\Model\Story;

class Index 
{
    /**
     *
     * @var PDO Object 
     */
    protected $db;
    
    /**
     *
     * @var Story 
     */
    protected $model;
    
    public function __construct(Story $story) 
    {
        $this->model = $story;
    }
    
    public function index() 
    {
        
        $stories = $this->model->getAllStories();
                
        $content = '<ol>';
        
        foreach($stories as $story) {

            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story?id=' . $story['id'] . '">' . $story['count'] . ' Comments</a> | 
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }
        
        $content .= '</ol>';
        
        require '../layout.phtml';
    }
}

