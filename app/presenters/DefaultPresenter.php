<?php

/**
 * Description of DefaultPresenter
 *
 * @author admin
 */
class DefaultPresenter extends BasePresenter
{
	protected $model;
	
	protected function startup()
	{
		parent::startup();
		$this->model = new RootModel('users');
	}

	public function actionDefault()
	{
	}
	
	protected function createComponentGrid()
	{
		$grid = new ACGrid('users');
		
		$grid->addText('username', 'User');
		$grid->addText('fullname', 'Full name');
		$grid->addSelect('rights', 'Role', array(1=>'Registered',2=>'Moderator',255=>'Administrator'));
		$grid->addRadio('gender', 'Gender', array(0=>'Man',1=>'Woman'));
		$grid->addImage('pic', 'Avatar');
		
		return $grid;
	}

	protected function createComponentPic()
	{
		$pic = new ACPic('images');
		return $pic;
	}
	
}

?>
