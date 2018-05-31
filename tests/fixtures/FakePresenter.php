<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Nette\Application\IPresenter;
use Nette\Application\IResponse;
use Nette\Application\Request;
use Nette\SmartObject;

class FakePresenter implements IPresenter
{

	use SmartObject;

	/** @var callable[]  function (Presenter $sender); Occurs when the presenter is starting */
	public $onStartup;

	/** @var callable[]  function (Presenter $sender, IResponse $response = null); Occurs when the presenter is shutting down */
	public $onShutdown;

	public function run(Request $request): IResponse
	{
	}

}
