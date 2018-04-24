<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\Application;
use Symfony\Component\EventDispatcher\Event;

class StartupEvent extends Event
{

	public const NAME = ApplicationEvents::ON_STARTUP;

	/** @var Application */
	private $application;

	public function __construct(Application $application)
	{
		$this->application = $application;
	}

	public function getApplication(): Application
	{
		return $this->application;
	}

}
