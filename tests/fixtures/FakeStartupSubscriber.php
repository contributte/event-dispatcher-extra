<?php

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Application\Event\StartupEvent;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
final class FakeStartupSubscriber implements EventSubscriber
{

	/** @var StartupEvent[] */
	public $onCall = [];

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [StartupEvent::NAME => 'onStartup'];
	}

	/**
	 * @param StartupEvent $event
	 * @return void
	 */
	public function onStartup(StartupEvent $event)
	{
		$this->onCall[] = $event;
	}

}
