<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Latte;

use Latte\Engine;
use Symfony\Contracts\EventDispatcher\Event;

class LatteCompileEvent extends Event
{

	/** @var Engine */
	private $engine;

	public function __construct(Engine $engine)
	{
		$this->engine = $engine;
	}

	public function getEngine(): Engine
	{
		return $this->engine;
	}

}
