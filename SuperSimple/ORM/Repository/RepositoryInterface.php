<?php
/**
 * Repository interface
 * Governs extended repo classes
 * @package Model/Repository
 * @author Pete Robinson <work@pete-robinson.co.uk>
 **/
namespace SuperSimple\ORM\Repository;
use SuperSimple\ORM\Entity\EntityInterface;

interface RepositoryInterface
{
	/**
	 * persist
	 * @param object $entity
	 * @return void
	 **/
	public function persist(EntityInterface $entity);

	/**
	 * map data to object
	 * @param array $entities
	 * @param bool $singular
	 * @return array
	 **/
	public function mapData($data, $singular = false);

}