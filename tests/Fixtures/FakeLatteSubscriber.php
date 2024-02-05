<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Events\Extra\Event\Latte\LatteBeforeCompileEvent;
use Contributte\Events\Extra\Event\Latte\LatteBeforeRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class FakeLatteSubscriber implements EventSubscriberInterface
{

	/** @var Event[] */
	public array $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			LatteBeforeCompileEvent::class => 'onLatteBeforeCompile',
			LatteBeforeRenderEvent::class => 'onLatteBeforeRender',
		];
	}

	public function onLatteBeforeCompile(LatteBeforeCompileEvent $event): void
	{
		$this->onCall[] = $event;
	}

	public function onLatteBeforeRender(LatteBeforeRenderEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
