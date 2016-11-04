<?php

class PackagesstoretypeController extends PackagesstoretypeControllerBase
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

	public function actionDelete($id)
	{
		$this->Delete($id);
	}

	public function actionIndex()
	{
		
		$this->Index();
	}

}
