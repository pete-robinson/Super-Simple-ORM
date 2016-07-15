<?php
/**
 * Cd entity
 * @package App\Entity
 * @author Pete Robinson
 **/
namespace SuperSimple\ORM\Tests\Lib\Entity;
use SuperSimple\ORM\Entity\EntityInterface;

class Cd implements EntityInterface
{
	/**
	 * id
	 * @var int
	 **/
	private $id;

	/**
	 * name
	 * @var string
	 **/
	private $name;

	/**
	 * slug
	 * @var string
	 **/
	private $slug;

	/**
	 * get id
	 * @return int
	 **/
	public function getId()
	{
		return $this->id;
	}

	/**
	 * set id
	 * @param int $id
	 * @return self
	 **/
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * get slug
	 * @return string
	 **/
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * set slug
	 * @param string $slug
	 * @return self
	 **/
	public function setSlug($slug)
	{
		$this->slug = $slug;
		return $this;
	}

	/**
	 * get name
	 * @return string
	 **/
	public function getName()
	{
		return $this->name;
	}

	/**
	 * set name
	 * @param string $name
	 * @return self
	 **/
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

}