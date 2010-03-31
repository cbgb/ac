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
	/** @var string */
	protected $table;

	/** @var RootModel */
	protected $model;

	/** @var ArrayObject */
	protected $columns;

	/** @var string */
	protected $header;

	/** @var string */
	protected $newCap;

	/** @var string */
	protected $delCap;

	/** @var string */
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

	public function getNewCap() {
		return $this->newCap;
	}

	public function setNewCap($newCap) {
		$this->newCap = $newCap;
	}

	public function getDelCap() {
		return $this->delCap;
	}

	public function setDelCap($delCap) {
		$this->delCap = $delCap;
	}

	public function getRate() {
		return $this->rate;
	}

	public function setRate($rate) {
		$this->rate = $rate;
	}


	/**
	 * function addText
	 *
	 * Add TEXT column
	 *
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param string $width		column width
	 */
	public function addText($index, $caption = NULL, $width = NULL)
	{
		$this->columns->append(new ACGridText($index, $caption));
	}
	
	/**
	 * function addDateTime
	 *
	 * Add DATETIME column
	 *
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param string $format	column format
	 * @param string $width		column width
	 */
	public function addDateTime($index, $caption = NULL, $format = 'j.n.Y H:i:s', $width = NULL)
	{
		$this->columns->append(new ACGridDateTime($index, $caption, $format, $width));
	}

	/**
	 * function addSeelect
	 *
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
	 * function addRadio
	 *
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
	 * function addImage
	 *
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
	 * function render
	 *
	 * Renders the template
	 */
	public function render()
	{
		$rowset = $this->model->findAll()->fetchAll();

		$this->template->header = $this->header;
		$this->template->cols = $this->columns;
		$this->template->rowset = $rowset;
		$this->template->rate = $this->rate;
		$this->template->newCap = $this->newCap;
		$this->template->delCap = $this->delCap;
		
		$this->template->setFile(dirname(__FILE__) . '/acgrid.phtml');
		$this->template->render();
	}


	/**
	 * handle Server
	 *
	 * AJAX request server handle
	 */
	public function handleServer()
	{
		foreach ($_POST as $var => $value) $$var = $value;

		$result = 'Ok';					//suppose success

		switch ($cmd) {
			case 'update':				//case update command
				if (!$this->model->update($row, array($col => $content))) $result = 'Update failed';
				else {
					if ($type == 'html') {
						if(!$rec = $this->model->find($row)->fetch()) $result = 'Fetching new value failed';
						else {
							$this->presenter->payload->html = $this->getHtml($col, $rec);
						}
					}
				}
				break;
			case 'new':																			//case new record
				if (!$this->model->insert(array())) $result = 'Insert failed';
				break;
			case 'delete':
				$where = $this->getQuery($content);
				if ($where) $this->model->deleteX($where);
				else $result = $where . ' - To je výraz ? To je hnus a né výraz.';
				break;
		}
		$this->presenter->payload->result = $result;
		$this->presenter->terminate(new JsonResponse($this->presenter->payload));
	}

	/**
	 * function getHtml
	 *
	 * Utility - returns required DIV block
	 *
	 * @param string $index			required column
	 * @param DibiFluent $row		table record
	 * @return string						html block
	 */
	protected function getHtml($index, $row)
	{
		foreach ($this->columns as $column) {
			if ($column->index == $index) {
				$html = $column->render($row);
				break;
			}
		}
		ob_start();
		echo $html;
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	/**
	 * function getQuery
	 * 
	 * Utility - parses the selection expression
	 *
	 * @param string $expr	expression to parse
	 * @return string				SQL WHERE condition
	 */
	protected function getQuery($expr)
	{
		$str = '';
		$expr = trim($expr);
		if ($expr == '*') $str = '1';
		else $str = 'id=' . $expr;
		return $str;
	}

}

?>