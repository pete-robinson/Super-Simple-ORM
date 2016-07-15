<?php
/**
 * abstract repository
 * Base repository functionality.
 * @package SuperSimple\ORM\Repository
 * @author Pete Robinson <work@pete-robinson.co.uk>
 * @todo - implement more complex query creation
 **/
namespace SuperSimple\ORM\Repository;
use \PDO;
use \PDOStatement;

abstract class AbstractRepository extends \PDO
{
	/**
	 * find all
	 * @param mixed $order_by
	 * @param int $limit
	 * @return array
	 **/
	public function findAll($order_by = false, $limit = false)
	{
		// construct base of query string
		$query_string = 'SELECT * FROM ' . static::TABLE_NAME;

		// add order by if exists
		if(is_array($order_by)) {
			$query_string .= ' ORDER BY ' . key($order_by) . ' ' . $order_by[key($order_by)];
		}

		// add limit if exists
		if($limit) {
			$query_string .= ' LIMIT :limit';
		}

		// prepare query
		$query = $this->prepare($query_string);

		// bind limit if necessary
		if($limit) {
			$query->bindParam('limit', $limit);
		}

		// execute query and fetch data
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_ASSOC);

		// map data and return
		return $this->mapData($results);
	}

	/**
	 * find
	 * @param int $id
	 * @return object
	 **/
	public function find($id)
	{
		// prepare query
		$query = $this->prepare('SELECT * FROM ' . static::TABLE_NAME . ' WHERE id = :id');
		
		// execute query and bind ID parameter
		$query->execute(array(
			'id' => $id
		));

		// fetch associative result
		$result = $query->fetch(PDO::FETCH_ASSOC);

		// map data and return
		return $this->mapData($result, true);
	}

	/**
	 * save entity and return ID
	 * @param PDOStatement $query
	 * @return integer
	 **/
	protected function save(PDOStatement $query)
	{
		$query->execute();
		return $this->lastInsertId();
	}

}