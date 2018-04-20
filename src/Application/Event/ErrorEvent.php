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
class ErrorEvent extends AbstractApplicationEvent
{

	const NAME = ApplicationEvents::ON_ERROR;

	/** @var Application */
	private $application;

	/** @var Throwable|Exception|Error */
	private $throwable;

	/**
	 * @param Application $application
	 * @param Throwable|Exception|Error $throwable
	 */
	public function __construct(Application $application, $throwable)
	{
		if (!($throwable instanceof Exception) && !($throwable instanceof Error)) {
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
	 * @return Throwable|Error|Exception
	 */
	public function getThrowable()
	{
		return $this->throwable;
	}

}
