<?php
/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Image column class
 *
 */
class ACGridImg extends ACGridColumn
{
	protected $folder;
	protected $thPrefix;
	protected $path;
	protected $uri;
	protected $width;
	protected $height;
	protected $defaultImage;


	/**
	 * Constructor
	 * 
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param string $folder	image thumbnail directory
	 * @param integer $width	column width (in pixels)
	 * @param integer $height column height (in pixels)
	 */
	public function  __construct($index, $caption, $folder, $width, $height) {
		parent::__construct($index, $caption, $width);
		$this->folder = $folder ? $folder : 'images/thumbs';
		$this->path = WWW_DIR . '/' . $this->folder;
		$this->uri = Environment::getVariable('baseUri') . $this->folder;
		$this->width = $width ? $width : 90;
		$this->height = $height ? $height : 60;
		$this->thPrefix = 'thumb_';
		$this->defaultImage = 'empty.png';
	}


	/****** Setters & Getters **********************/

	public function setFolder($folder) {
		$this->folder = $folder;
	}

	public function setWidth($width) {
		$this->width = $width;
	}

	public function setHeight($height) {
		$this->height = $height;
	}

	public function setDefaultImage($defaultImage) {
		$this->defaultImage = $defaultImage;
	}

	public function setThPrefix($thPrefix) {
		$this->thPrefix = $thPrefix;
	}


	/**
	 * Render the html block
	 *
	 * @param DibiFluent $row	table row
	 * @return string					html block
	 */
	public function filter($row)
	{
		$uri = $this->uri . '/' . $this->thPrefix . $this->defaultImage;
		$filename = '';
		$w = $this->width;
		$h = $this->height;

		//compute image dimensions (if any)
		if ($row[$this->index]) {
			$filename = $row[$this->index];
			$path = $this->path . '/' . $this->thPrefix . $filename;
			if (file_exists($path)) {
				$img = Image::fromFile($path);
				$w = $img->getWidth();
				$h = $img->getHeight();

				$rw = $this->width / $w;
				$rh = $this->height / $h;

				if ($rw > $rh) {
					$h = $this->height;
					$w *= $rh;
				} else {
					$w = $this->width;
					$h *= $rw;
				}
				$w = round($w, 0);
				$h = round($h, 0);
				$uri = $this->uri . '/' . $this->thPrefix . $filename;
			}
		}

		$html = Html::el('div')->class('image')->title($filename)
			->style(array('width' => $this->width . 'px', 'height' => $this->height . 'px'));
		$html->create('img')->src($uri)->alt($filename)
			->style(array('width' => $w . 'px', 'height' => $h . 'px'));

		return $html;
	}

}
?>
