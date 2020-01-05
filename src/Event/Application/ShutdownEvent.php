<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\Application;
use Symfony\Contracts\EventDispatcher\Event;
use Throwable;

class ShutdownEvent extends Event
{

	/** @var Application */
	private $application;

	/** @var Throwable|null */
	private $throwable;

	public function __construct(Application $application, ?Throwable $throwable = null)
	{
		$this->application = $application;
		$this->throwable = $throwable;
	}

	public function getApplication(): Application
	{
		return $this->application;
	}

	public function getThrowable(): ?Throwable
	{
		return $this->throwable;
	}

}
