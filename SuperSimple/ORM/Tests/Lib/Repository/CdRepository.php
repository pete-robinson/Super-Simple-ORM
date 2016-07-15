<?php
/**
 * Cd repo
 *
 * @package Model\Repository
 * @author Pete Robinson
 **/
namespace SuperSimple\ORM\Tests\Lib\Repository;

use SuperSimple\ORM\Entity\EntityInterface;
use SuperSimple\ORM\Repository\AbstractRepository;
use SuperSimple\ORM\Repository\RepositoryInterface;
use SuperSimple\ORM\Tests\Lib\Entity\Cd;

class CdRepository extends AbstractRepository implements RepositoryInterface
{
	/**
	 * table name constant
	 * @var string
	 **/
	const TABLE_NAME = 'cds';

	/**
	 * persist
	 * @param object EntityInterface $entity
	 * @return void
	 **/
	public function persist(EntityInterface $entity)
	{
		// prepare query
		$query = $this->prepare('INSERT INTO ' . self::TABLE_NAME . ' (slug, name) VALUES (:slug, :name)');

		// bind slug and name
		$query->bindParam('slug', $entity->getSlug());
		$query->bindParam('name', $entity->getName());
		
		return $this->save($query);
	}

	/**
	 * map data
	 * @param mixed $data
	 * @return mixed
	 **/
	public function mapData($data, $singular = false)
	{
		// init return variable
		$return = false;

		if($data) {
			// if singular response required
			if($singular) {
				// instantiate new object
				$return = new Cd;
				// map data
				$return
					->setId($data['id'])
					->setSlug($data['slug'])
					->setName($data['name'])
				;
			} else {
				// array to map, not singular
				$return = array();
				foreach($data as $key => $entity) {
					$return[$key] = new Cd;
					$return[$key]
						->setId($entity['id'])
						->setSlug($entity['slug'])
						->setName($entity['name'])
					;
				}
			}
		}

		return $return;
	}

}