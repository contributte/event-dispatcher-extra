<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Event\Security\LoggedInEvent;
use Contributte\Events\Extra\Event\Security\SecurityEvents;

final class FakeLoggedInSubscriber implements EventSubscriber
{

	/** @var LoggedInEvent[] */
	public $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [SecurityEvents::ON_LOGGED_IN => 'onLoggedIn'];
	}

	public function onLoggedIn(LoggedInEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
