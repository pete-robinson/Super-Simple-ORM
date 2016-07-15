# Super-Simple-ORM
A super-simple ORM extended from PDO for projects that require a minor database layer.

This ORM essentially allows you to implement a simple ORM layer for projects with a simple level of database interaction where you may not want to use a more robust solution such as Doctrine.

## Architecture
Each table in data must have corresponding Entity and Repository classes. As with other ORMs, an Entity represents a single instance of data and a repository deals with data as a collection (i.e. Entity = a car. Repository = many cars).

The Factory class is used for fetching repositories which will return an instance of the repository for the requested data structure.

Entity classes must be written and passed to the repository class to be persisted to the database.


## Usage
Each data strucutre requires an Entity and a Repository class.

To create an entity, you must implement the interface SuperSimple\ORM\Entity\EntityInterface. An entity class essentially consists of getters and setters for your data structure.

```php
<?php
/**
 * Cd entity
 **/
namespace MyApp\ORM\Entity;
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
```

To create an repository, you must extend SuperSimple\ORM\Repository\AbstractRepository and implement SuperSimple\ORM\Repository\RepositoryInterface. Each repository class must have a persist method with deals with the data structure and a mapData method in order to map results to objects. In future, I will abstract this responsibilty to the library itself rather than user-added classes.

```php
<?php
/**
 * Cd repository
 **/
namespace MyApp\ORM\Repository;

use SuperSimple\ORM\Entity\EntityInterface;
use SuperSimple\ORM\Repository\AbstractRepository;
use SuperSimple\ORM\Repository\RepositoryInterface;
use MyApp\ORM\Entity\Cd;

class CdRepository extends AbstractRepository implements RepositoryInterface
{
	/**
	 * table name constant
	 * @var string
	 **/
	const TABLE_NAME = 'cds';

	/**
	 * persist
	 * @param object Page $entity
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
```

### Fetching data
To fetch and request data from a repository:

```php
use SuperSimple\ORM\Factory;

// init factory
$factory = new Factory([
	'dsn' => /*...*/,
	'username' => /*...*/
	'password' => /*...*/
]);

// fetch all - requires namespace (minus Repository element)
// returns a mapped array of Cd entity objects
$results = $factory->fetch('MyApp\ORM:Cd')->findAll();

// optional ordering (field => order)
$results = $factory->fetch('MyApp\ORM:Cd')->findAll([
	'name' => 'ASC'
]);

// optional result limiting (10 in this example)
$results = $factory->fetch('MyApp\ORM:Cd')->findAll(false, 10);

// fetch one (by ID)
// returns an object of requested entity if data exists
$results = $factory->fetch('MyApp\ORM:Cd')->find($id);
```

### Working with entities

#### Exploring data
Entities represent data hydrated into your Entity object for a given data structure.

```php
use SuperSimple\ORM\Factory;

// init factory
$factory = new Factory([
	'dsn' => /*...*/,
	'username' => /*...*/
	'password' => /*...*/
]);

// find one entity
$cd = $factory->fetch('MyApp\ORM:Cd')->find($id);

echo $cd->getId();
echo $cd->getName();
echo $cd->getSlug();
```

#### Persisting
```php
use SuperSimple\ORM\Factory;
use MyApp\ORM\Entity\Cd;

// init factory
$factory = new Factory([
	'dsn' => /*...*/,
	'username' => /*...*/
	'password' => /*...*/
]);

// find one entity
$repo = $factory->fetch('MyApp\ORM:Cd');

// create a new data object
$new_cd = new Cd;
$new_cd
	->setName('Artist Name')
	->setSlug('artist-name')
;

// save to database
$repo->persist($new_cd);
```


## Limitations
1. need to implement a more secure method of ordering. Currently constructed straight from input parameters as PDO doesn't like using order params as bound arguments
2. Need to implement a more developer-friendly way of the library understand data structures and not having to define them with RepositoryInterface::mapData
3. Does not update or delete - retrieve and persist only
