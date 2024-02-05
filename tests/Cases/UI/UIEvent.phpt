<?php declare(strict_types = 1);

use Contributte\Tester\Toolkit;
use Tester\Assert;
use Tests\Fixtures\FakeUiEvent;

require_once __DIR__ . '/../../bootstrap.php';

// Success message
Toolkit::test(function (): void {
	$event = new FakeUiEvent();
	$event->getUi()->addSuccessMessage('All clear');

	Assert::equal([(object) ['message' => 'All clear', 'type' => 'success']], $event->getUi()->getMessages());
});
