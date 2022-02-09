<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\UI;

use ArrayIterator;
use Contributte\EventDispatcher\Exceptions\Logical\InvalidStateException;
use IteratorAggregate;

/**
 * @phpstan-implements IteratorAggregate<string, mixed>
 */
class Changeset implements IteratorAggregate
{

	/** @var mixed[] */
	private $changeset = [];

	/**
	 * @param string|int $key
	 * @param mixed      $value
	 */
	public function add($key, $value): void
	{
		$this->changeset[$key] = $value;
	}

	/**
	 * @param string|int $key
	 */
	public function has($key): bool
	{
		return array_key_exists($key, $this->changeset);
	}

	/**
	 * @param string|int $key
	 * @return mixed
	 */
	public function get($key)
	{
		if (!$this->has($key)) {
			throw new InvalidStateException(sprintf('Key %s does not exist in this changeset', (string) $key));
		}

		return $this->changeset[$key];
	}

	/**
	 * @return mixed[]
	 */
	public function all(): array
	{
		return $this->changeset;
	}

	/**
	 * @return ArrayIterator<string, mixed>
	 */
	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->changeset);
	}

}
