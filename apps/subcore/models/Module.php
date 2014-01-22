<?php 

/**
 * Class UserAddress Extend of Row, simplyfing data access and modification
 * Holds the {@link UserAddress} model
 * @package spiderFrame
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 */
class Module extends Row
{
    private static $table = "cat_module";
  
	public function __construct($id, DbConnection $DbConnection = null)
	{
		parent::__construct(self::$table, (int)$id, $DbConnection);
	}
	  
	public static function getInstance($id, DbConnection $DbConnection = null)
	{
	 	if ( !isset(parent::$_instances[self::$table][$id]) ) 
	    {
	      $Row = new Module((int)$id, $DbConnection);
	      parent::$_instances[self::$table][$id] = $Row;
	    } 
	    return parent::$_instances[self::$table][$id];
	}
	
	public function getModulePermissions()
  	{
  		 $sql = "SELECT 
		 			cat_module_permission.cat_module_permission_id,
		 			cat_module_permission.permission, 
		 			cat_module_permission.permission_context, 
		 			cat_module_permission.description, 
		 			cat_module_permission.active		 			
				FROM 
					cat_module, cat_module_permission 
				WHERE 
					cat_module_permission.cat_module_id = cat_module.cat_module_id	  
				AND
					cat_module.cat_module_id = '{$this->id}'
				ORDER BY cat_module_permission.active DESC
			";
  	
  		return $this->DbConnection->getAll($sql);
  	}
  
	
}
