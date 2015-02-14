<?php

namespace Masterclass\Controller;

use Savage\BooBoo\Formatter\AbstractFormatter;
use Aura\View\View;

class Error extends AbstractFormatter
{
    protected $template;
    
    public function __construct(View $template)
    {
        $this->template = $template;
    }
    
    public function format(\Exception $e)
    {
        $this->template->setLayout('layout');
        $this->template->setView('error');
        return $this->template->__invoke();
    }
}

