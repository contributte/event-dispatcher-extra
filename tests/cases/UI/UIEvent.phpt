<?php

/**
 * Test: UI/UIEvent
 */

use Tester\Assert;
use Tests\Fixtures\FakeUiEvent;

require_once __DIR__ . '/../../bootstrap.php';

// Success message
test(function () {
	$event = new FakeUiEvent();
	$event->getUi()->addSuccessMessage('All clear');

	Assert::equal([(object) ['message' => 'All clear', 'type' => 'success']], $event->getUi()->getMessages());
});
