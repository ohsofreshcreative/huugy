<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ProductConfigurator extends Field
{
	/**
	 * Warstwy podglądu produktu zmiennego, podmieniane po wyborze wariantu.
	 * Lista opcji pola configurator_option jest budowana z atrybutów WooCommerce (app/filters.php).
	 *
	 * @return array
	 */
	public function fields(): array
	{
		$configurator = new FieldsBuilder('product_configurator_fields', [
			'title' => 'Konfigurator produktu',
			'style' => 'default',
			'position' => 'normal',
		]);

		$configurator
			->setLocation('post_type', '==', 'product')
			->addRepeater('product_configurator', [
				'label' => 'Warstwy konfiguratora',
				'instructions' => 'Działa dla produktów zmiennych z atrybutami globalnymi. Każda wartość atrybutu dostaje własny obraz PNG z przezroczystym tłem i tym samym kadrem. Kolejność atrybutów odpowiada kolejności warstw: pierwszy atrybut na liście jest na spodzie (np. najpierw stelaż, potem deski). Gdy konfigurator jest uzupełniony, zastępuje galerię produktu.',
				'layout' => 'table',
				'button_label' => 'Dodaj warstwę',
			])
			->addSelect('configurator_option', [
				'label' => 'Wartość atrybutu',
				'required' => 1,
				'ui' => 1,
				'return_format' => 'value',
			])
			->addImage('image', [
				'label' => 'Obraz warstwy',
				'return_format' => 'array',
				'required' => 1,
				'preview_size' => 'thumbnail',
			])
			->endRepeater();

		return [$configurator];
	}
}
