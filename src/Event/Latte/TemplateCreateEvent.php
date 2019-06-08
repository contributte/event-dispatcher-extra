<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Latte;

use Nette\Bridges\ApplicationLatte\Template;


class TemplateCreateEvent extends \Symfony\Component\EventDispatcher\Event
{

	public const NAME = self::class;

	/** @var Template */
	private $template;

	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	public function getTemplate(): Template
	{
		return $this->template;
	}

}
