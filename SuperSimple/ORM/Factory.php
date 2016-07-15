<?php
/**
 * Repository factory
 * Used to return a new instance of a repository
 * @package Model
 * @author Pete Robinson <work@pete-robinson.co.uk>
 **/
namespace SuperSimple\ORM;
use SuperSimple\ORM\Exception\OrmException;

final class Factory
{
	/**
	 * DB dsn
	 * @var string
	 **/
	private $dsn;

	/**
	 * DB username
	 * @var string
	 **/
	private $username;

	/**
	 * DB password
	 * @var string
	 **/
	private $password;

	/**
	 * constructor
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @return void
	 **/
	public function __construct($config)
	{
		$this->dsn = $config['dsn'];
		$this->username = $config['username'];
		$this->password = $config['password'];
	}

	/**
	 * fetch repository
	 * @param string $repository
	 * @return object RepositoryInterface
	 **/
	public function fetch($repository)
	{
		/**
		 * explore repository name by colon...
		 * [0] = repository namespace
		 * [1] = $repository name
		 */
		$parts = explode(':', $repository);

		// construct namespace
		$namespace = '\\' . $parts[0] . '\\Repository\\' . $parts[1] . 'Repository';

		// check class exists
		if(class_exists($namespace)) {
			// instantiate class, pass in DB connection details
			return new $namespace($this->dsn, $this->username, $this->password);
		} else {
			// class doesn't exist
			throw new OrmException('Model not found');
		}
	}

}