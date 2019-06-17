<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Events\Extra\Event\Security\LoggedInEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class FakeLoggedInSubscriber implements EventSubscriberInterface
{

	/** @var LoggedInEvent[] */
	public $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [LoggedInEvent::class => 'onLoggedIn'];
	}

	public function onLoggedIn(LoggedInEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
