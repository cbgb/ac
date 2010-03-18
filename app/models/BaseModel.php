<?php

/**
 * @author Ladislak Liholak
 * @copyright 2009
 */

abstract class BaseModel extends Object implements IModel
{
	/** @var	DibiConnection */
	protected $connection;
	
	/** @var	string	table name */
	protected $table;
	
	/** @var	string	primary key */
	protected $primary = 'id';

	/** @var	array		of function(IModel $sender) */
	public $onStartup;
	
	/** @var	array		of function(IModel $sender) */
	public $onShutdown;
	

	public function __construct($table = NULL)
	{
		$this->onStartup($this);
		$this->connection = dibi::getConnection();
		
		if($table) $this->table = $table;
	}
	
	public function __destruct()
	{
		$this->onShutdown($this);
	}
	
	public static function initialize()
	{
		$conf = Environment::getConfig('database');
		$connection = dibi::connect($conf);
		
		if($conf->profiler) {
			$profiler = is_numeric($conf->profiler) || is_bool($conf->profiler) ?
				new DibiProfiler : new $conf->profiler;
			$profiler->setFile(Environment::expand('%logDir%') . '/sql.log');
			$connection->setProfiler($profiler);
		}
	}
	
	public static function disconnect()
	{
		dibi::getConnection()->disconnect();
	}
	

	/****** Geters and setters ***********/
	
	public function getTable()
	{
		return $this->table;
	}
	
	public function setTable($table)
	{
		$this->table = $table;
	}
	
	public function getPrimary()
	{
		return $this->primary;
	}
	
	public function setPrimary($primary)
	{
		$this->primary = $primary;
	}
	
	public function getConnection()
	{
		return $this->connection;
	}
	
	
	/****** Table operations *************/
	
	public function findAll()
	{
		return $this->connection->select('*')->from($this->table);
	}
	
	public function find($key)
	{
		return $this->findAll()->where("$this->primary = %i", $key);
	}
	
	public function insert(array $data)
	{
		return $this->connection->insert($this->table, $data)->execute(dibi::IDENTIFIER);
	}
	
	public function update($id, array $data)
	{
		return $this->connection->update($this->table, $data)->where("$this->primary = %i", $id)->execute();
	}
	
	public function delete($id)
	{
		return $this->connection->delete($this->table)->where("$this->primary = %i", $id)->execute();
	}
	
}

?>