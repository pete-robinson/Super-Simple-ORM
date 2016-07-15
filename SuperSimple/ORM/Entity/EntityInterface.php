<?php
/**
 * entity interface
 * Governs entities
 * @package SuperSimple\ORM\Entity
 * @author Pete Robinson <work@pete-robinson.co.uk>
 **/
namespace SuperSimple\ORM\Entity;

interface EntityInterface
{

	/**
	 * get it
	 * @return int
	 **/
	public function getId();

	/**
	 * set id
	 * @param int $id
	 * @return object self
	 **/
	public function setId($id);

}