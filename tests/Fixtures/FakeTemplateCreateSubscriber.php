<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class FakeTemplateCreateSubscriber implements EventSubscriberInterface
{

	/** @var TemplateCreateEvent[] */
	public array $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [TemplateCreateEvent::class => 'onTemplateCreate'];
	}

	public function onTemplateCreate(TemplateCreateEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
