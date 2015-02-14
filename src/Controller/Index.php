<?php
 
namespace Masterclass\Controller;

use Masterclass\Model\Story;
use Aura\View\View;
use Aura\Web\Response;
use Aura\Web\Request;

class Index 
{
    /**
     *
     * @var Story 
     */
    protected $model;
    
    protected $request;
    
    protected $response;

    protected $template;
    
    public function __construct(Story $story, Request $request, Response $response, View $view) 
    {
        $this->model = $story;
        $this->template = $view;
        $this->response = $response;
        
    }
    
    public function index() 
    {
        $stories = $this->model->getAllStories();
        $this->template->setLayout('layout');
        $this->template->setView('index');
        
        $this->template->setData(['stories' => $stories]);
        $this->response->content->set($this->template->__invoke());

        return $this->response;
    }
}

