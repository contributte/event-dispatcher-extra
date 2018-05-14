<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Event\Latte\LatteCompileEvent;
use Contributte\Events\Extra\Event\Latte\LatteEvents;

final class FakeLatteCompileSubscriber implements EventSubscriber
{

	/** @var LatteCompileEvent[] */
	public $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [LatteEvents::ON_LATTE_COMPILE => 'onLatteCompile'];
	}

	public function onLatteCompile(LatteCompileEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
