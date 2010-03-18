<?php

/**
 * @author Ladislak Liholak
 * @copyright 2009
 */

interface IModel
{
	/**
	 * Setups database connection
	 * @return	void
	 */
	public static function initialize();
	
	
	/****** Public setters & getters *****/
	
	/**
	 * Gets table name
	 * @return	string	table name
	 */
	public function getTable();
	
	/**
	 * Sets table name
	 * @param		string	table name
	 * @return	void
	 */
	public function setTable($table);
	
	/**
	 * Gets primary key
	 * @return	int|string
	 */
	public function getPrimary();
	
	/**
	 * Sets primary key
	 * @param		int|string
	 * @return	void
	 */
	public function setPrimary($primary);

	
	/****** Table operations *************/
	
	/**
	 * Returns whole table
	 * @return	DibiFluent
	 */
	public function findAll();
	
	/**
	 * Returns a record
	 * @param		primary key
	 * @return	DibiFluent
	 */
	public function find($primary);
	
	/**
	 * Inserts a record
	 * @param		array
	 * @return	DibiFluent
	 */
	public function insert(array $data);
	
	/**
	 * Updates a record
	 * @param		primary key
	 * @param		array
	 * @return	DibiFluent
	 */
	public function update($id, array $data);
	
	/**
	 * Deletes a record
	 * @param		primary key
	 * @return	DibiFluent
	 */
	public function delete($id);

}

?>