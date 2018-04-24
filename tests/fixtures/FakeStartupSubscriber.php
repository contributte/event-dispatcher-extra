<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Event\Application\StartupEvent;

final class FakeStartupSubscriber implements EventSubscriber
{

	/** @var StartupEvent[] */
	public $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [StartupEvent::NAME => 'onStartup'];
	}

	public function onStartup(StartupEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
