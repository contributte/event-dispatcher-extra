<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Event\Application\ApplicationEvents;
use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;

class FakePresenterStartupSubscriber implements EventSubscriber
{

	/** @var PresenterStartupEvent[] */
	public $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [ApplicationEvents::ON_PRESENTER_STARTUP => 'onPresenterStartup'];
	}

	public function onPresenterStartup(PresenterStartupEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
