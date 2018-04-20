<?php

namespace Contributte\Events\Extra\Application\UI;

use Contributte\Events\Extra\Application\AbstractApplicationEvent;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
abstract class UIEvent extends AbstractApplicationEvent
{

	/** @var UI */
	private $ui;

	/** @var Changeset */
	private $changeset;

	/**
	 * @return UI
	 */
	public function getUi()
	{
		if (!$this->ui) {
			$this->ui = new UI();
		}

		return $this->ui;
	}

	/**
	 * @return Changeset
	 */
	public function getChangeset()
	{
		if (!$this->changeset) {
			$this->changeset = new Changeset();
		}

		return $this->changeset;
	}

}
