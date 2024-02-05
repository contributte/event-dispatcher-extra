<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Events\Extra\Event\Latte\LatteCompileEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class FakeLatteCompileSubscriber implements EventSubscriberInterface
{

	/** @var LatteCompileEvent[] */
	public array $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [LatteCompileEvent::class => 'onLatteCompile'];
	}

	public function onLatteCompile(LatteCompileEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
