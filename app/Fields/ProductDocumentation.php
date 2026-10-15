<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductDocumentation extends Field
{
	public function fields(): array
	{
		$documentation = new FieldsBuilder('product_documentation_fields', [
			'title' => 'Dokumentacja techniczna',
			'style' => 'default',
			'position' => 'normal',
		]);

		$documentation
			->setLocation('post_type', '==', 'product')
			->addRepeater('product_documentation', [
				'label' => 'Dokumenty',
				'layout' => 'table',
				'button_label' => 'Dodaj dokument',
			])
			->addText('title', ['label' => 'Nazwa dokumentu', 'required' => 1])
			->addFile('file', ['label' => 'Plik', 'return_format' => 'array', 'required' => 1])
			->endRepeater();

		return [$documentation];
	}
}
