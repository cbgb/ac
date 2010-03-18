<?php

/**
 * @author Ladislak Liholak
 * @copyright 2010
 */

class ACL extends Permission
{
	public function __construct()
	{
		$this->addRoles();
		$this->addResources();
		$this->addAllows();
	}
	
	public function addRoles()
	{
		$this->addRole('guest');
		$this->addRole('registered', 'guest');
		$this->addRole('admin');
	}

	public function addResources()
	{
		$this->addResource('Default');
		$this->addResource('Login');
		$this->addResource('Chat');
	}
	
	/**
	 * Add allows
	 */
	public function addAllows()
	{
		$this->allow('guest', array('Default','Login'), array('default'));
		$this->allow('guest', array('Login'), array('register'));
		$this->allow('admin');
	}
	
}

?>