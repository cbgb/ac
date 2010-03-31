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
		$grid = new ACGrid('users', 'Users');
		$grid->addText('username', 'Username');
		$grid->addText('fullname', 'Fullname');
		$grid->addSelect('rights', 'Role', array(1=>'Registered',2=>'Moderator',255=>'Administrator'));
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
