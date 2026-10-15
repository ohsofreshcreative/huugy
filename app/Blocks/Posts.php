<?php

namespace App\Blocks;

use App\Support\SectionClasses;
use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Posts extends Block
{
	public $name = 'Baza wiedzy - Ostatnie wpisy';
	public $description = 'posts';
	public $slug = 'posts';
	public $category = 'formatting';
	public $icon = 'admin-post';
	public $keywords = ['posts', 'category', 'wpisy', 'kategoria'];
	public $mode = 'edit';
	public $supports = [
		'align' => false,
		'mode' => true,
		'jsx' => true,
	];

	public function fields()
	{
		$posts = new FieldsBuilder('posts');

		$posts
			->setLocation('block', '==', 'acf/posts')
			/*--- FIELDS ---*/
			->addTab('Treści', ['placement' => 'top'])
			->addGroup('posts_settings', ['label' => ''])

			->addText('title', ['label' => 'Tytuł'])
			->addWysiwyg('text', [
				'label' => 'Opis',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])

			->addLink('button', [
				'label' => 'Przycisk',
				'return_format' => 'array',
			])

			->addTrueFalse('show_image', [
				'label' => 'Pokaż obrazek',
				'default_value' => 1,
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])

			->addTrueFalse('show_excerpt', [
				'label' => 'Pokaż fragment treści',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Tak',
				'ui_off_text' => 'Nie',
			])

			->endGroup()

			/*--- USTAWIENIA BLOKU ---*/

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
			]);

		return $posts;
	}

	public function with(): array
	{
		$settings = get_field('posts_settings');
		$settings = is_array($settings) ? $settings : [];
		$query = new \WP_Query([
			'post_type' => 'post',
			'posts_per_page' => 3,
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC',
			'ignore_sticky_posts' => true,
			'no_found_rows' => true,
		]);

		$items = [];
		foreach ($query->posts as $post) {
			$categories = get_the_category($post->ID);
			$items[] = [
				'title' => get_the_title($post),
				'url' => get_permalink($post),
				'image' => get_post_thumbnail_id($post),
				'category' => $categories[0]->name ?? '',
				'date' => get_the_date('d.m.Y', $post),
				'datetime' => get_the_date('c', $post),
				'excerpt' => get_the_excerpt($post),
			];
		}

		$blog_id = (int) get_option('page_for_posts');
		$fields = [
			'posts_settings' => $settings,
			'items' => $items,
			'button' => !empty($settings['button']['url']) ? $settings['button'] : ($blog_id ? [
				'url' => get_permalink($blog_id),
				'title' => 'Sprawdź naszego bloga!',
			] : []),
			'show_image' => (bool) ($settings['show_image'] ?? true),
			'show_excerpt' => (bool) ($settings['show_excerpt'] ?? false),
			'section_id' => get_field('section_id'),
			'section_class' => get_field('section_class'),
			'wide' => (bool) get_field('wide'),
			'flip' => (bool) get_field('flip'),
			'nomt' => (bool) get_field('nomt'),
			'gap' => (bool) get_field('gap'),
			'background' => get_field('background') ?: get_field('default_block_background', 'option') ?: 'none',
		];
		$fields['sectionClass'] = SectionClasses::fromMap($fields, [
			'wide' => 'wide',
			'flip' => 'order-flip',
			'nomt' => '!mt-0',
			'gap' => 'wider-gap',
		]);

		return $fields;
	}
}
