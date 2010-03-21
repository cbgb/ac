<?php
/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * class ACGrid
 *
 * Editable grid component
 */
class ACGrid extends Control
{
	protected $table;	

	protected $model;

	protected $columns;

	protected $header;

	protected $page;

	protected $rate;


	/**
	 * Constructor
	 * 
	 * @param string $table table name
	 * @param string $header table header
	 */
	public function __construct($table = NULL, $header = NULL)
	{
		parent::__construct();
		$this->columns = new ArrayObject();
		$this->table = $table;
		$this->model = new RootModel($table);
		$this->header = $header ? $header : strtoupper($table);
		$this->rate = 'fast';
	}
	

	/***************** Getters & Setters ********************/

	public function setTable($table) {
		$this->table = $table;
	}

	public function getColumns() {
		return $this->columns;
	}

	public function setColumns($columns) {
		$this->columns = $columns;
	}

	public function setHeader($header) {
		$this->header = $header;
	}

	public function setRate($rate) {
		$this->rate = $rate;
	}


	/**
	 * Add TEXT column
	 *
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param string $width		column width
	 * @param string $html		special html markup for column
	 */
	public function addText($index, $caption = NULL, $width = NULL, $html = NULL)
	{
		$this->columns->append(new ACGridText($index, $caption, $html));
	}
	
	/**
	 * Add SELECTBOX driven column
	 * 
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param <type> $options	inline options for selectbox
	 * @param <type> $width		column width
	 */
	public function addSelect($index, $caption = NULL, $options = NULL, $width = NULL)
	{
		$this->columns->append(new ACGridSelect($index, $caption, $options, $width));
	}
	
	/**
	 * Add RADIOBUTTON column
	 * 
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param <type> $options	inline options for radiobuttons list
	 * @param <type> $width		column width
	 */
	public function addRadio($index, $caption = NULL, $options = NULL, $width = NULL)
	{
		$this->columns->append(new ACGridRadio($index, $caption, $options, $width));
	}

	/**
	 * Add IMAGE column
	 * 
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param <type> $folder	image	thumbnails directory
	 * @param <type> $width		image width
	 * @param <type> $height	image height
	 */
	public function addImage($index, $caption = NULL, $folder = NULL, $width = NULL, $height = NULL)
	{
		$this->columns->append(new ACGridImg($index, $caption, $folder, $width, $height));
	}
	

	/**
	 * Renders the template
	 */
	public function render()
	{
		$rowset = $this->model->findAll()->fetchAll();

		$this->template->header = $this->header;
		$this->template->cols = $this->columns;
		$this->template->rowset = $rowset;
		$this->template->rate = $this->rate;
		
		$this->template->setFile(dirname(__FILE__) . '/acgrid.phtml');
		$this->template->render();
	}


	/**
	 * AJAX request server handle
	 */
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

	/**
	 * Supply required DIV
	 *
	 * @param string $index			required column
	 * @param DibiFluent $row		table record
	 * @return string						html block
	 */
	protected function getFilter($index, $row)
	{
		foreach ($this->columns as $column) {
			if ($column->index == $index) {
				$html = $column->filter($row);
				break;
			}
		}
		return $html;
	}

}

?>