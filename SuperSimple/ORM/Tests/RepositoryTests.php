<?php
/**
 * Repo tests
 * @package SuperSimple\ORM\Tests
 * @author Pete Robinson <work@pete-robinson.co.uk>
 **/
namespace SuperSimple\ORM\Tests;
use SuperSimple\ORM\Factory;
use SuperSimple\Tests\Lib\Repository\CdRepository;
use SuperSimple\ORM\Tests\Lib\Entity\Cd;

class RepositoryTests extends TestBase
{
	/**
	 * setup
	 * @return void
	 **/
	public function setUp()
	{
		$this->createFixtures();
	}

	/**
	 * test find all
	 * @return void
	 **/
	public function testFindAll()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:Cd');

		$results = $repo->findAll();

		$this->assertEquals(2, count($results));
	}

	/**
	 * test singular results are entities
	 * @return void
	 **/
	public function testSingularResultsAreEntities()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:Cd');

		$cd = $repo->find(1);
		
		$this->assertInstanceOf('SuperSimple\ORM\Tests\Lib\Entity\Cd', $cd);
	}

	/**
	 * test multiple results are arrays and entities
	 * @return void
	 **/
	public function testMultipeResultsAreArraysAndEntities()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:Cd');

		$results = $repo->findAll();
		
		$this->assertTrue(is_array($results));

		foreach($results as $item) {
			$this->assertInstanceOf('SuperSimple\ORM\Tests\Lib\Entity\Cd', $item);
		}
	}

	/**
	 * test order by
	 * @return void
	 **/
	public function testOrderBy()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:Cd');

		// get ordered by slug desc
		$results = $repo->findAll([
			'slug' => 'DESC'
		]);
		
		// first item should be test-cd-2
		$this->assertEquals($results[0]->getId(), '2');
	}

	/**
	 * test limit
	 * @return void
	 **/
	public function testLimit()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:Cd');

		// get ordered by slug desc
		$results = $repo->findAll(false, 1);
		
		// one result
		$this->assertEquals(count($results), 1);
	}

	/**
	 * test save
	 * @return void
	 **/
	public function testSave()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:Cd');

		$cd = new Cd;
		$cd
			->setSlug('test-cd-3')
			->setName('Test CD 3')
		;

		$id = $repo->persist($cd);

		// fetch the new object
		$new = $repo->find($id);

		$this->assertInstanceOf('SuperSimple\ORM\Tests\Lib\Entity\Cd', $new);
		$this->assertEquals($new->getName(), $cd->getName());
		$this->assertEquals($new->getSlug(), $cd->getSlug());
	}
}