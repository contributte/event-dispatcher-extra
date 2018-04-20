<?php

namespace Contributte\Events\Extra\Application\Event;

use Contributte\Events\Extra\Application\AbstractApplicationEvent;
use Nette\Application\Application;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class StartupEvent extends AbstractApplicationEvent
{

	const NAME = ApplicationEvents::ON_STARTUP;

	/** @var Application */
	private $application;

	/**
	 * @param Application $application
	 */
	public function __construct(Application $application)
	{
		$this->application = $application;
	}

	/**
	 * @return Application
	 */
	public function getApplication()
	{
		return $this->application;
	}

}
