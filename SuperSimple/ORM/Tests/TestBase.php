<?php
/**
 * test base
 * @package ORM\Tests
 * @author Pete Robinson <work@pete-robinson.co.uk>
 **/
namespace SuperSimple\ORM\Tests;
use \SQLiteDatabase;

abstract class TestBase extends \PHPUnit_Framework_TestCase
{
	/**
	 * DB resource
	 * @var resource
	 **/
	private $db;

	protected $dsn;

	public function __construct()
	{
		$this->dsn = [
			'dsn' => 'sqlite:' . $this->getTmpDbPath(),
			'username' => null,
			'password' => null
		];

		parent::__construct();
		parent::setUpBeforeClass();
	}

	/**
	 * create fixtures
	 * @return void
	 **/
	protected function createFixtures()
	{
		$db_path = $this->getDbPath();

		if(file_exists($this->getTmpDbPath())) {
			@unlink($this->getTmpDbPath());
		}

		copy($this->getDbPath(), $this->getTmpDbPath());

	}

	/**
	 * get path to test DB
	 * @return string
	 **/
	protected function getDbPath()
	{
		return __DIR__ . '/var/data.db';
	}

	/**
	 * get path to test DB
	 * @return string
	 **/
	protected function getTmpDbPath()
	{
		return __DIR__ . '/var/tmp_data.db';
	}

}