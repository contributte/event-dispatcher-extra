<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Latte;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;
use Symfony\Component\EventDispatcher\Event;

class TemplateCreateEvent extends Event
{

	public const NAME = LatteEvents::ON_TEMPLATE_CREATE;

	/** @var Template */
	private $template;

	/** @var Control */
	private $control;

	public function __construct(Template $template, Control $control)
	{
		$this->template = $template;
		$this->control = $control;
	}

	public function getTemplate(): Template
	{
		return $this->template;
	}

	public function getControl(): Control
	{
		return $this->control;
	}
}
