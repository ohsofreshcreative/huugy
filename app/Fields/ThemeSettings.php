<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ThemeSettings extends Field
{
	public function fields(): array
	{
		$theme = new FieldsBuilder('theme_settings');

		$theme
			->setLocation('options_page', '==', 'theme-settings')
			->addTab('Layout', ['placement' => 'top'])
			->addSelect('default_block_background', [
				'label' => 'Domyślne tło bloków',
				'choices' => \App\Support\SectionClasses::backgroundChoices(),
				'default_value' => 'none',
				'ui' => 0,
				'allow_null' => 0,
			])

			->addTab('Logo', ['placement' => 'top'])
			->addImage('logo', [
				'label' => 'Logo',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
			])
			->addImage('logo_footer', [
				'label' => 'Logo Stopka',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
			])

			->addTab('Dane kontaktowe (Stopka)', ['placement' => 'top'])
			->addGroup('footer_contact', ['label' => 'Dane kontaktowe stopki'])

			->addWysiwyg('address', [
				'label' => 'Adres / Dane firmy',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addWysiwyg('hours', [
				'label' => 'Godziny otwarcia',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addText('phone', [
				'label' => 'Numer telefonu',
			])
			->addText('email', [
				'label' => 'Adres E-mail',
			])
			->addRepeater('social_links', [
				'label' => 'Social media',
				'layout' => 'table',
				'button_label' => 'Dodaj link',
			])
			->addImage('icon', [
				'label' => 'Ikona',
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
			])
			->addUrl('link', [
				'label' => 'Link URL',
			])
			->endRepeater()
			->endGroup()
			->addTab('Panel logowania', ['placement' => 'top'])
			->addGroup('login_modal', ['label' => 'Treści panelu logowania'])
			->addText('header', [
				'label' => 'Nagłówek logowania',
				'default_value' => 'Zaloguj się',
			])
			->addText('email_label', [
				'label' => 'Etykieta adresu e-mail',
				'default_value' => 'Twój adres e-mail',
			])
			->addText('email_placeholder', [
				'label' => 'Przykład adresu e-mail',
				'default_value' => 'nazwa@domena.pl',
			])
			->addText('password_label', [
				'label' => 'Etykieta hasła',
				'default_value' => 'Hasło',
			])
			->addText('login_label', [
				'label' => 'Tekst przycisku logowania',
				'default_value' => 'Zaloguj się',
			])
			->addText('lost_password_label', [
				'label' => 'Tekst linku odzyskiwania hasła',
				'default_value' => 'Zapomniałeś hasła?',
			])
			->addText('register_header', [
				'label' => 'Nagłówek rejestracji',
				'default_value' => 'Nie masz konta?',
			])
			->addWysiwyg('text', [
				'label' => 'Treść zachęty do rejestracji',
				'default_value' => 'Zarejestruj się i uzyskaj dostęp do:',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addWysiwyg('models_text', [
				'label' => 'Treść przy ikonie modeli 3D',
				'default_value' => 'modeli 3D naszych produktów',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addWysiwyg('documentation_text', [
				'label' => 'Treść przy ikonie dokumentacji',
				'default_value' => 'specyfikacji technicznej naszych produktów',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addWysiwyg('news_text', [
				'label' => 'Treść przy ikonie nowości',
				'default_value' => 'informacji o nowościach i zrealizowanych projektach',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addText('register_label', [
				'label' => 'Tekst przycisku rejestracji',
				'default_value' => 'Zarejestruj się',
			])
			->addWysiwyg('registration_unavailable_text', [
				'label' => 'Komunikat o wyłączonej rejestracji',
				'default_value' => 'Rejestracja kont jest obecnie niedostępna.',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => true,
			])
			->addText('close_label', [
				'label' => 'Etykieta zamknięcia panelu (dla czytników ekranu)',
				'default_value' => 'Zamknij panel logowania',
			])
			->endGroup()
			->addTab('Newsletter', ['placement' => 'top'])
			->addGroup('footer_newsletter', ['label' => 'Newsletter w stopce'])
			->addText('header', [
				'label' => 'Nagłówek',
				'default_value' => 'Zapisz się do naszego newslettera',
			])
			->addText('shortcode', [
				'label' => 'Kod formularza newslettera',
				'instructions' => 'Wklej shortcode formularza połączonego z Twoją listą mailingową.',
			])
			->endGroup();

		return [$theme];
	}
}
