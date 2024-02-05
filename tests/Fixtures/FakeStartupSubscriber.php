<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Events\Extra\Event\Application\StartupEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class FakeStartupSubscriber implements EventSubscriberInterface
{

	/** @var StartupEvent[] */
	public array $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [StartupEvent::class => 'onStartup'];
	}

	public function onStartup(StartupEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
