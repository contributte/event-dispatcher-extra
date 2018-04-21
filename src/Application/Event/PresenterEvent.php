<?php

namespace Contributte\Events\Extra\Application\Event;

use Contributte\Events\Extra\Application\AbstractApplicationEvent;
use Nette\Application\Application;
use Nette\Application\IPresenter;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class PresenterEvent extends AbstractApplicationEvent
{

	const NAME = ApplicationEvents::ON_PRESENTER;

	/** @var Application */
	private $application;

	/** @var IPresenter */
	private $presenter;

	/**
	 * @param Application $application
	 * @param IPresenter $presenter
	 */
	public function __construct(Application $application, IPresenter $presenter)
	{
		$this->application = $application;
		$this->presenter = $presenter;
	}

	/**
	 * @return Application
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * @return IPresenter
	 */
	public function getPresenter()
	{
		return $this->presenter;
	}

}
