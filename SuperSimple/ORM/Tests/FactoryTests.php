<?php
/**
 * Factory tests
 * @package SuperSimple\ORM\Tests
 * @author Pete Robinson <work@pete-robinson.co.uk>
 **/
namespace SuperSimple\ORM\Tests;
use SuperSimple\ORM\Factory;
use SuperSimple\Tests\Lib\CdRepository;

class FactoryTests extends TestBase
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
	 * test factory returns repository
	 * @return void
	 **/
	public function testFactoryReturnsRepository()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:Cd');

		// check that repository is returned
		$this->assertInstanceOf('SuperSimple\ORM\Tests\Lib\Repository\CdRepository', $repo);
	}

	/**
	 * undocumented function
	 * @expectedException SuperSimple\ORM\Exception\OrmException
	 * @return void
	 **/
	public function testExceptionThrownForUnknownRepository()
	{
		// init factory
		$factory = new Factory($this->dsn);

		// call repo
		$repo = $factory->fetch('SuperSimple\ORM\Tests\Lib:FakeRepo');
	}
}