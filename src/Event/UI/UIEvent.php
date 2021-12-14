<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\UI;

use Symfony\Contracts\EventDispatcher\Event;

abstract class UIEvent extends Event
{

	/** @var UI */
	private $ui;

	/** @var Changeset<mixed> */
	private $changeset;

	public function getUi(): UI
	{
		if ($this->ui === null) {
			$this->ui = new UI();
		}

		return $this->ui;
	}

	/** @return Changeset<mixed> */
	public function getChangeset(): Changeset
	{
		if ($this->changeset === null) {
			$this->changeset = new Changeset();
		}

		return $this->changeset;
	}

}
