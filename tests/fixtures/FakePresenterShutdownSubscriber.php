<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Event\Application\ApplicationEvents;
use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;

class FakePresenterShutdownSubscriber implements EventSubscriber
{

	/** @var PresenterShutdownEvent[] */
	public $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [ApplicationEvents::ON_PRESENTER_SHUTDOWN => 'onPresenterShutdown'];
	}

	public function onPresenterShutdown(PresenterShutdownEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
