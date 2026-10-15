<?php

namespace App\Blocks;

use App\Support\SectionClasses;
use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Find extends Block
{
	public $name = 'Find';
	public $description = 'Sekcja z materiałami po zalogowaniu';
	public $slug = 'find';
	public $category = 'formatting';
	public $icon = 'screenoptions';
	public $keywords = ['materialy', 'pliki', 'logowanie'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
		'anchor' => true,
		'customClassName' => true,
	];

	public function fields()
	{
		$find = new FieldsBuilder('find');

		$find
			->setLocation('block', '==', 'acf/find')
			->addTab('Elementy', ['placement' => 'top'])
			->addGroup('g_find', ['label' => ''])
			->addText('header', ['label' => 'Nagłówek'])
			->addImage('image', [
				'label' => 'Grafika po prawej',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
			])
			->endGroup()

			->addTab('Elementy do pobrania', ['placement' => 'top'])
			->addRepeater('r_find', [
				'label' => 'Elementy',
				'layout' => 'table',
				'button_label' => 'Dodaj element',
			])
			->addText('label', ['label' => 'Etykieta'])
			->endRepeater()

			->addTab('Ustawienia bloku', ['placement' => 'top'])
			->addText('section_id', [
				'label' => 'ID',
			])
			->addText('section_class', [
				'label' => 'Dodatkowe klasy CSS',
			])
			->addTrueFalse('flip', [
				'label' => 'Odwrotna kolejność',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('wide', [
				'label' => 'Szeroka kolumna',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('nomt', [
				'label' => 'Usunięcie marginesu górnego',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addTrueFalse('gap', [
				'label' => 'Większy odstęp',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addSelect('background', [
				'label' => 'Kolor tła',
				'choices' => SectionClasses::backgroundChoices(),
				'default_value' => 'none',
				'ui' => 0,
				'allow_null' => 0,
			]);

		return $find;
	}

	public function with(): array
	{
		$group = get_field('g_find');
		$rows = get_field('r_find');

		$fields = [
			'g_find' => is_array($group) ? $group : [],
			'r_find' => is_array($rows) ? array_values(array_filter($rows, 'is_array')) : [],

			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),

			'flip' => (bool) get_field('flip'),
			'wide' => (bool) get_field('wide'),
			'nomt' => (bool) get_field('nomt'),
			'gap' => (bool) get_field('gap'),

			'background' => get_field('background') ?: get_field('default_block_background', 'option') ?: 'none',
		];

		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'flip' => 'order-flip',
			'wide' => 'wide',
			'nomt' => '!mt-0',
			'gap' => 'wider-gap',
		]);

		return $fields;
	}
}