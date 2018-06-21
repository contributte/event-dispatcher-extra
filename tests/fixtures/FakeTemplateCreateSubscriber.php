<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Event\Latte\LatteEvents;
use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;

final class FakeTemplateCreateSubscriber implements EventSubscriber
{

	/** @var TemplateCreateEvent[] */
	public $onCall = [];

	/**
	 * @return string[]
	 */
	public static function getSubscribedEvents(): array
	{
		return [LatteEvents::ON_TEMPLATE_CREATE => 'onTemplateCreate'];
	}

	public function onTemplateCreate(TemplateCreateEvent $event): void
	{
		$this->onCall[] = $event;
	}

}
