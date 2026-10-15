<?php

namespace App\Options;

use Log1x\AcfComposer\Options;
use StoutLogic\AcfBuilder\FieldsBuilder;

class OShop extends Options
{
	public $name = 'Ustawienia sklepu';
	public $slug = 'oshop';
	public $title = 'Ustawienia sklepu';
	public $position = 103;
	public $capability = 'edit_posts';
	public $redirect = false;

	public function fields(): FieldsBuilder
	{
		$oshop = new FieldsBuilder('oshop');

		$oshop
			->addTab('Ustawienia hero', ['placement' => 'top'])
			->addGroup('g_oshop', ['label' => ''])
			->addImage('hero_image', [
				'label'         => 'Zdjęcie hero',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			])
			->addTextarea('hero_header', [
				'label' => 'Nagłówek hero',
				'instructions' => 'Zastępuje domyślny tytuł na głównej stronie sklepu. Dozwolone znaczniki: &lt;strong&gt;, &lt;em&gt;, &lt;a&gt;, &lt;br&gt;.',
			])
			->addWysiwyg('description', [
				'label' => 'Opis',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->endGroup()
			->addTab('Megamenu', ['placement' => 'top'])
			->addGroup('megamenu_promo', [
				'label' => 'Kafelek promocyjny',
				'instructions' => 'Megamenu wyświetla kategorie produktów pod pozycją menu prowadzącą do strony sklepu. Dla własnego odnośnika dodaj klasę CSS product-megamenu w edytorze menu.',
			])
			->addImage('image', [
				'label' => 'Zdjęcie',
				'return_format' => 'array',
				'preview_size' => 'medium',
			])
			->addText('header', ['label' => 'Nagłówek'])
			->addWysiwyg('text', [
				'label' => 'Treść',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addLink('button', [
				'label' => 'Link promocji',
				'return_format' => 'array',
			])
			->endGroup()
			->addTab('Panel klienta', ['placement' => 'top'])
			->addRepeater('account_icons', [
				'label' => 'Ikony menu i kafelków',
				'layout' => 'table',
				'button_label' => 'Dodaj ikonę',
			])
			->addText('endpoint', [
				'label' => 'Identyfikator podstrony',
				'instructions' => 'dashboard (Kokpit), orders (Zamówienia), edit-address (Adresy), edit-account (Szczegóły konta), downloads (Pliki), customer-logout (Wylogowanie).',
				'required' => 1,
			])
			->addImage('image', [
				'label' => 'Ikona',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'required' => 1,
			])
			->endRepeater()
			->addTab('Podziękowanie za zamówienie', ['placement' => 'top'])
			->addGroup('thankyou_settings', ['label' => ''])
			->addText('delivery_time', [
				'label' => 'Przewidywany czas dostawy',
				'instructions' => 'Opcjonalnie, np. 7–10 dni roboczych. Wspólna informacja dla zamówień wymagających wysyłki.',
			])
			->endGroup();

		return $oshop;
	}
}
