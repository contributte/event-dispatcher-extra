<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\UI;

use ArrayIterator;
use Contributte\Events\Extra\Exceptions\LogicalException;
use IteratorAggregate;

/**
 * @phpstan-implements IteratorAggregate<string, mixed>
 */
class Changeset implements IteratorAggregate
{

	/** @var mixed[] */
	private array $changeset = [];

	public function add(string|int $key, mixed $value): void
	{
		$this->changeset[$key] = $value;
	}

	public function has(string|int $key): bool
	{
		return array_key_exists($key, $this->changeset);
	}

	public function get(string|int $key): mixed
	{
		if (!$this->has($key)) {
			throw new LogicalException(sprintf('Key %s does not exist in this changeset', (string) $key));
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
