<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\UI;

use Nette\Application\UI\Control;
use stdClass;

class UI
{

	/** @var array<int, stdClass> */
	private $messages = [];

	/** @var string[] */
	private $snippets = [];

	/** @var stdClass */
	private $redirect;

	/**
	 * @return array<int, stdClass>
	 */
	public function getMessages(): array
	{
		return $this->messages;
	}

	/**
	 * @param array<int, stdClass> $messages
	 */
	public function setMessages(array $messages): void
	{
		$this->messages = $messages;
	}

	public function addDangerMessage(string $message): void
	{
		$this->addMessage($message, 'danger');
	}

	public function addInfoMessage(string $message): void
	{
		$this->addMessage($message, 'info');
	}

	public function addWarningMessage(string $message): void
	{
		$this->addMessage($message, 'warning');
	}

	public function addSuccessMessage(string $message): void
	{
		$this->addMessage($message, 'success');
	}

	/**
	 * @return string[]
	 */
	public function getSnippets(): array
	{
		return $this->snippets;
	}

	/**
	 * @param string[] $snippets
	 */
	public function setSnippets(array $snippets): void
	{
		$this->snippets = $snippets;
	}

	public function redrawSnippet(string $snippet): void
	{
		$this->snippets[] = $snippet;
	}

	/**
	 * @return mixed
	 */
	public function getRedirect()
	{
		return $this->redirect;
	}

	/**
	 * @param mixed[] $args
	 */
	public function setRedirect(string $destination, array $args = []): void
	{
		$this->redirect = (object) ['destination' => $destination, 'args' => $args];
	}

	public function setRefresh(): void
	{
		$this->setRedirect('this');
	}

	public function apply(Control $control): void
	{
		// Apply messages
		foreach ($this->messages as $message) {
			$control->flashMessage($message->message, $message->type);
		}

		// Apply snippets
		foreach ($this->snippets as $snippet) {
			$control->redrawControl($snippet);
		}

		// Apply redirect
		if ($this->redirect !== null) {
			$control->redirect($this->redirect->destination, $this->redirect->args);
		}
	}

	private function addMessage(string $message, string $type): void
	{
		$this->messages[] = (object) ['message' => $message, 'type' => $type];
	}

}
