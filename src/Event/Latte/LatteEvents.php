<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Latte;

interface LatteEvents
{

	/**
	 * Occurs before latte file is compiled
	 */
	public const ON_LATTE_COMPILE = 'nette.latte.compile';

}
