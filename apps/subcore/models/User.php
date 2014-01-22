<?php 

/**
 * Class User Extend of Row, simplyfing data access and modification
 * Holds the {@link User} model
 * @package spiderFrame
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 */
class User extends Row
{
    private static $table = "user";
  
	public function __construct($id, DbConnection $DbConnection = null)
	{
		parent::__construct(self::$table, (int)$id, $DbConnection);
	}
	  
	public static function getInstance($id, DbConnection $DbConnection = null)
	{
	 	if ( !isset(parent::$_instances[self::$table][$id]) ) 
	    {
	      $Row = new User((int)$id, $DbConnection);
	      parent::$_instances[self::$table][$id] = $Row;
	    } 
	    return parent::$_instances[self::$table][$id];
	}
}
