<?php

class DefaultControllerBase extends UTIController
{
	public $layout = '';
        
	public function Index()
	{
            $this->pageTitle = 'Управление пакетами';
		$this->render('index');
	}
}