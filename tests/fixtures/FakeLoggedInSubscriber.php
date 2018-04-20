<?php

namespace Tests\Fixtures;

use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Security\Event\LoggedInEvent;
use Contributte\Events\Extra\Security\Event\SecurityEvents;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
final class FakeLoggedInSubscriber implements EventSubscriber
{

	/** @var LoggedInEvent[] */
	public $onCall = [];

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [SecurityEvents::ON_LOGGED_IN => 'onLoggedIn'];
	}

	/**
	 * @param LoggedInEvent $event
	 * @return void
	 */
	public function onLoggedIn(LoggedInEvent $event)
	{
		$this->onCall[] = $event;
	}

}
