<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FakePresenterShutdownSubscriber implements EventSubscriberInterface
{

	/** @var PresenterShutdownEvent[] */
	public array $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [PresenterShutdownEvent::class => 'onPresenterShutdown'];
	}

	public function onPresenterShutdown(PresenterShutdownEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
