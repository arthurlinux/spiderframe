<?php  
  
if( !defined('TO_ROOT') ) { define('TO_ROOT', '..'); }
  
  /**
 * Provides a General Functions
 * Holds the {@link Functions} class
 * @author Arturo Osorio <arosbar@gmail.com>
 * @author Ismael Cortés <may.estilosfrescos@gmail.com>
 * @copyright Copyright (c) 2010, Ismael Cortés <may.estilosfrescos@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package spiderFrame
 */

class FiscalFunctions extends Functions
{
  	/**
  	 * Get all Client on Array Pair
  	 * @param enum 1 or 0 $active
  	 * @param DbConnection $DbConnection
  	 */
	public static function __getClient($active = "1", DbConnection $DbConnection = null) 
	{
	  	$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	$sql = "SELECT cat_client_id, client FROM cat_client WHERE active_client = '{$active}' ";
	  	
	  	return $DbConnection->getPair($sql);
	}
	
	public static function __getClientCompanies($id, DbConnection $DbConnection = null) 
	{
	  	$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	  	$sql = "SELECT cat_company_id, company, administrator, active_company FROM cat_company WHERE cat_client_id = '{$id}' ";
	  	
	  	return $DbConnection->getAll($sql);
	}
	
	public static function __getCompanyAddressID($id, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	 			
	  	$sql = "SELECT 
	  				user_address.user_address_id 
	  			FROM 
	  				user_address, cat_company
	  			WHERE 
					cat_company.cat_company_id = user_address.user_id 
				AND 
					cat_company.cat_company_id = '{$id}'
	  			AND 
	  				user_address.cat_address_id = '7'";
	  	
	  	return $DbConnection->getValue($sql);
	}
	
	public static function __getClientAddressID($id, DbConnection $DbConnection = null) 
	{
		$DbConnection = ($DbConnection == null) ? DbConnection::getInstance("_root") : $DbConnection ;
	 			
	  	$sql = "SELECT 
	  				user_address.user_address_id 
	  			FROM 
	  				user_address, cat_client
	  			WHERE 
					cat_client.cat_client_id = user_address.user_id 
				AND 
					cat_client.cat_client_id = '{$id}'
	  			AND 
	  				user_address.cat_address_id = '6'";
	  	
	  	return $DbConnection->getValue($sql);
	}

	 
}