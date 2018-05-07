<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Forms;

interface FormFactory
{

	public function create(): Form;

}
