<?php

class PackagesstoreController extends PackagesstoreControllerBase
{

	public function actionView($id)
	{
		$this->View($id);
	}

	public function actionCreate()
	{
		$this->Create();
	}

	public function actionUpdate($id)
	{
		$this->Update($id);
	}

	public function actionFlag($id)
	{
		$this->Flag($id);
	}

	
	public function actionDelete($id)
	{
		$this->Delete($id);
	}

	public function actionIndex()
	{
		
		$this->Index();
	}

}
