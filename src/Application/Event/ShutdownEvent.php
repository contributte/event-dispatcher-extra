<?php

namespace Contributte\Events\Extra\Application\Event;

use Contributte\EventDispatcher\Exceptions\Logical\InvalidArgumentException;
use Contributte\Events\Extra\Application\AbstractApplicationEvent;
use Error;
use Exception;
use Nette\Application\Application;
use Throwable;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class ShutdownEvent extends AbstractApplicationEvent
{

	const NAME = ApplicationEvents::ON_SHUTDOWN;

	/** @var Application */
	private $application;

	/** @var Exception|Error|Throwable */
	private $throwable;

	/**
	 * @param Application $application
	 * @param Exception|Error|Throwable $throwable
	 */
	public function __construct(Application $application, $throwable = NULL)
	{
		if ($throwable && !($throwable instanceof Exception) && !($throwable instanceof Error)) {
			throw new InvalidArgumentException(sprintf('Exception must be instance of Exception|Error'));
		}

		$this->application = $application;
		$this->throwable = $throwable;
	}

	/**
	 * @return Application
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * @return Error|Exception|Throwable
	 */
	public function getThrowable()
	{
		return $this->throwable;
	}

}
