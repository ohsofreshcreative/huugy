<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Support\SectionClasses;

class Slider extends Block
{
    public $name = 'Slider';
    public $description = 'slider';
    public $slug = 'slider';
    public $category = 'formatting';
    public $icon = 'image-flip-horizontal';
    public $keywords = ['slider', 'kafelki'];
    public $mode = 'edit';
    public $supports = [
        'align' => false,
        'mode' => true,
        'jsx' => true,
    ];

    public function fields()
    {
        $slider = new FieldsBuilder('slider');

        $slider
            ->setLocation('block', '==', 'acf/slider')
			/*--- GROUP ---*/
			->addTab('Elementy', ['placement' => 'top'])
			->addGroup('g_slider', ['label' => ''])
            ->addText('header', ['label' => 'Tytuł sekcji'])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->endGroup()

			/*--- KAFELKI ---*/
			->addTab('Kafelki', ['placement' => 'top'])
			->addRepeater('r_slider', [
				'label' => 'Kafelki',
				'layout' => 'block',
				'min' => 1,
				'button_label' => 'Dodaj kafelek',
			])
			->addImage('image', [
				'label' => 'Obraz tła',
				'return_format' => 'array',
				'preview_size' => 'medium',
			])
			->addText('header', [
				'label' => 'Nagłówek',
			])
			->addTextarea('text', [
				'label' => 'Tekst',
				'rows' => 3,
				'new_lines' => 'br',
			])
			->endRepeater()

			/*--- USTAWIENIA BLOKU ---*/

            ->addTab('Ustawienia bloku', ['placement' => 'top'])
            ->addText('section_id', ['label' => 'ID'])
            ->addText('section_class', ['label' => 'Dodatkowe klasy CSS'])
            ->addTrueFalse('nomt', [
                'label' => 'Usunięcie marginesu górnego',
                'ui' => 1,
                'ui_on_text' => 'Tak',
                'ui_off_text' => 'Nie',
            ])
			->addTrueFalse('bgshape', [
				'label' => 'Kształt w tle',
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])
			->addSelect('background', [
				'label' => 'Kolor tła',
				'choices' => \App\Support\SectionClasses::backgroundChoices(),
				'default_value' => 'none',
				'ui' => 0,
				'allow_null' => 0,
			]);

        return $slider;
    }

    public function with(): array
    {
        $rows = get_field('r_slider') ?: [];

        $slides = [];
        foreach ($rows as $row) {
            $image = $row['image'] ?? null;
            $slides[] = [
                'header'    => $row['header'] ?? '',
                'text'      => $row['text'] ?? '',
                'image_url' => $image['url'] ?? null,
                'image_alt' => $image['alt'] ?? '',
            ];
        }

        $fields = [
            'slides'       => $slides,
			'g_slider' => get_field('g_slider'),
            'section_id'   => get_field('section_id'),
            'section_class' => get_field('section_class'),
            'nomt'         => (bool) get_field('nomt'),
			'bgshape' => (bool) get_field('bgshape'),
            'background'   => get_field('background') ?: 'none',
        ];

        $fields['sectionClass'] = SectionClasses::fromMap($fields, [
            'nomt' => '!mt-0',
        ]);

        return $fields;
    }
}
