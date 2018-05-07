<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\UI\Control;
use Nette\Application\UI\ITemplate;
use Symfony\Component\EventDispatcher\Event;

class TemplateCreateEvent extends Event
{

	public const NAME = ApplicationEvents::ON_TEMPLATE_CREATE;

	/** @var ITemplate */
	private $template;

	/**@var Control */
	private $control;

	public function __construct(ITemplate $template, Control $control)
	{
		$this->template = $template;
		$this->control = $control;
	}

	public function getTemplate(): ITemplate
	{
		return $this->template;
	}

	public function getControl(): Control
	{
		return $this->control;
	}
}
