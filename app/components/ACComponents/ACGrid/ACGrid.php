<?php

/**
 * @author Petr Blažíček
 * @copyright 2010
 */

class ACGrid extends Control
{
	protected $table;	
	protected $model;
	protected $columns;
	protected $header;
	protected $page;


	public function __construct($table = NULL, $header = NULL)
	{
		parent::__construct();
		$this->columns = new ArrayObject();
		$this->table = $table;
		$this->model = new RootModel($table);
		$this->header = $header ? $header : strtoupper($table);
	}
	

	/***************** Getters & Setters ********************/
	public function getTable() {
		return $this->table;
	}

	public function setTable($table) {
		$this->table = $table;
	}

	public function getColumns() {
		return $this->columns;
	}

	public function setColumns($columns) {
		$this->columns = $columns;
	}

	public function getHeader() {
		return $this->header;
	}

	public function setHeader($header) {
		$this->header = $header;
	}


	public function addText($index, $caption = NULL, $width = NULL, $html = NULL)
	{
		$this->columns->append(new ACGridText($index, $caption, $html));
	}
	
	public function addSelect($index, $caption = NULL, $options = NULL, $width = NULL)
	{
		$this->columns->append(new ACGridSelect($index, $caption, $options, $width));
	}
	
	public function addRadio($index, $caption = NULL, $options = NULL, $width = NULL)
	{
		$this->columns->append(new ACGridRadio($index, $caption, $options, $width));
	}

	public function addImage($index, $caption = NULL, $folder = NULL, $width = NULL, $height = NULL)
	{
		$this->columns->append(new ACGridImg($index, $caption, $folder, $width, $height));
	}
	

	public function render()
	{
		$rowset = $this->model->findAll()->fetchAll();

		$this->template->header = $this->header;
		$this->template->cols = $this->columns;
		$this->template->rowset = $rowset;
		$this->template->r = 0;
		
		$this->template->setFile(dirname(__FILE__) . '/acgrid.phtml');
		$this->template->render();
	}

	public function handleServer()
	{
		foreach ($_POST as $var => $value) $$var = $value;

		$wrk['result'] = 'Ok';	//suppose success

		switch ($cmd) {
			case 'update':
				if (!$this->model->update($row, array($col => $content))) $wrk['result'] = 'Failed';
				else {
					if ($type == 'html') {
						if(!$rec = $this->model->find($row)->fetch()) $res = '0';
						else $res = $this->getFilter($col, $rec);				//prepare HTML response
					} else $res = json_encode($wrk);									//JSON response
				}
				break;
		}
		die ($res);
	}

	protected function getFilter($col, $rec)
	{
		foreach ($this->columns as $column) {
			if ($column->index == $col) {
				$html = $column->filter($rec);
				break;
			}
		}
		return $html;
	}

}

?>