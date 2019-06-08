<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\IPresenter;
use Symfony\Component\EventDispatcher\Event;

class PresenterStartupEvent extends Event
{

	public const NAME = self::class;

	/** @var IPresenter */
	private $presenter;

	public function __construct(IPresenter $presenter)
	{
		$this->presenter = $presenter;
	}

	public function getPresenter(): IPresenter
	{
		return $this->presenter;
	}

}
