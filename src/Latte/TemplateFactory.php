<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Latte;

use Nette\Application\UI\Control;
use Nette\Application\UI\ITemplateFactory;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Bridges\ApplicationLatte\TemplateFactory as NetteTemplateFactory;
use Nette\SmartObject;

class TemplateFactory implements ITemplateFactory
{
	use SmartObject;

	/** @var callable[]  function (Template $template, Control $control); Occurs during template creating */
	public $onCreate = [];

	/** @var NetteTemplateFactory */
	private $templateFactory;

	public function __construct(NetteTemplateFactory $templateFactory)
	{
		$this->templateFactory = $templateFactory;
	}

	public function createTemplate(?Control $control = null): Template
	{
		$template = $this->templateFactory->createTemplate($control);
		$this->onCreate($template, $control);
		return $template;
	}
}
