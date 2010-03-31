<?php
/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * class ACGridImg
 *
 * Image column class
 */
class ACGridImg extends ACGridColumn
{
	/** @var string */
	protected $folder;

	/** @var string */
	protected $thPrefix;

	/** @var string */
	protected $path;

	/** @var string */
	protected $uri;

	/** @var integer */
	protected $width;

	/** @var integer */
	protected $height;

	/** @var string */
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

	public function getFolder() {
		return $this->folder;
	}

	public function setFolder($folder) {
		$this->folder = $folder;
	}

	public function getThPrefix() {
		return $this->thPrefix;
	}

	public function setThPrefix($thPrefix) {
		$this->thPrefix = $thPrefix;
	}

	public function getPath() {
		return $this->path;
	}

	public function setPath($path) {
		$this->path = $path;
	}

	public function getUri() {
		return $this->uri;
	}

	public function setUri($uri) {
		$this->uri = $uri;
	}

	public function getWidth() {
		return $this->width;
	}

	public function setWidth($width) {
		$this->width = $width;
	}

	public function getHeight() {
		return $this->height;
	}

	public function setHeight($height) {
		$this->height = $height;
	}

	public function getDefaultImage() {
		return $this->defaultImage;
	}

	public function setDefaultImage($defaultImage) {
		$this->defaultImage = $defaultImage;
	}


	/**
	 * Render the html block
	 *
	 * @param DibiFluent $row	table row
	 * @return string					html block
	 */
	public function render($row)
	{
		$uri = $this->uri . '/' . $this->thPrefix . $this->defaultImage; //suppose no image
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
