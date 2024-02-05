<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FakePresenterStartupSubscriber implements EventSubscriberInterface
{

	/** @var PresenterStartupEvent[] */
	public array $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [PresenterStartupEvent::class => 'onPresenterStartup'];
	}

	public function onPresenterStartup(PresenterStartupEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
