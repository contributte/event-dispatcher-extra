<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Latte;

use Latte\Engine;
use Symfony\Contracts\EventDispatcher\Event;

class LatteBeforeCompileEvent extends Event
{

	private Engine $engine;

	public function __construct(Engine $engine)
	{
		$this->engine = $engine;
	}

	public function getEngine(): Engine
	{
		return $this->engine;
	}

}
