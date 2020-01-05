<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\Application;
use Nette\Application\IPresenter;
use Symfony\Contracts\EventDispatcher\Event;

class PresenterEvent extends Event
{

	/** @var Application */
	private $application;

	/** @var IPresenter */
	private $presenter;

	public function __construct(Application $application, IPresenter $presenter)
	{
		$this->application = $application;
		$this->presenter = $presenter;
	}

	public function getApplication(): Application
	{
		return $this->application;
	}

	public function getPresenter(): IPresenter
	{
		return $this->presenter;
	}

}
