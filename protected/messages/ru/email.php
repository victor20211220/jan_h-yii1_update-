<?php
return array(
	"Email has been sent" => "Письмо было отправлено",
    "Banner or TextLink"=>"Баннер или текстовую ссылку",
    "Contact Form"=>"Контактную форму",

	// Subject's
	"Email Subject Approved Regular" => "{BrandName}: Поздравляем. Ваша ссылка была одобрена и добавлена!",
	"Email Subject Approved Premium" => "{BrandName}: Поздравляем. Ваша ссылка была одобрена и добавлена!",

	"Email Subject Rejected Regular" => "{BrandName}: К сожалению ваша ссылка не была одобрена.",
	"Email Subject Rejected Premium" => "{BrandName}: К сожалению ваша ссылка не была одобрена.",

	"Email Subject Waiting Regular" => "{BrandName}: Важное примечание относительно отправки ссылки",
	"Email Subject Waiting Premium" => "{BrandName}: Важное примечание относительно отправки ссылки",


	// Free approved
	"Email Body Approved Regular" => "Дорогой(-ая) {Username},<br><br>
Мы рады сообщить вам, что ваша ссылка \"{Title}\" была добавлена в веб-каталог {HomeUrl}<br><br>
Название: {Title}<br>
Категория: {CategoryPath}<br>
Ссылка: {Link}<br><br>
Чтобы удалить атрибут nofollow из вашей ссылки, вы должны вставить {Banner or TextLink} и затем связаться с нами через {ContactForm}.
<br><br>
С наилучшими пожеланиями,<br>
Команда {HomeUrl}<br>
",

	// Premium approved
	"Email Body Approved Premium" => "Дорогой(-ая) {Username},<br><br>
Мы рады сообщить вам, что ваша ссылка \"{Title}\" была добавлена в веб-каталог {HomeUrl}<br><br>
Название: {Title}<br>
Категория: {CategoryPath}<br>
Ссылка: {Link}<br><br>
С наилучшими пожеланиями,<br>
Команда {HomeUrl}<br>
",

	// Free waiting
	"Email Body Waiting Regular" => "Дорогой(-ая) {Username},<br><br>
Спасибо за вашу отправку \"{Title}\" в {HomeUrl}<br>
Из-за большого количества отправленных ссылок процесс добавления ссылки в каталог может занять от 1 или более месяца.<br><br>
Чтобы удалить атрибут nofollow из вашей ссылки, вы должны вставить {Banner or TextLink} и затем связаться с нами через {ContactForm}.<br><br>
С наилучшими пожеланиями,<br>
Команда {HomeUrl}<br>
",
	// Premium waiting
	"Email Body Waiting Premium" => "Дорогой(-ая) {Username},<br><br>
Спасибо за вашу отправку \"{Title}\" в {HomeUrl}<br><br>
С наилучшими пожеланиями,<br>
Команда {HomeUrl}<br>",

	// Free rejected
	"Email Body Rejected Regular" => "Дорогой(-ая) {Username},<br><br>
Мы не хотим разочаровывать вас, но ваша отправленная ссылка не прошла модерацию и не была добавлена в каталог:<br>
{Url}<br><br>
С наилучшими пожеланиями,<br>
Команда {HomeUrl}<br>
",

	// Premium rejected
	"Email Body Rejected Premium" => "Дорогой(-ая) {Username},<br><br>
Мы не хотим разочаровывать вас, но ваша отправленная ссылка не прошла модерацию и не была добавлена в каталог:<br>
{Url}<br><br>
С наилучшими пожеланиями,<br>
Команда {HomeUrl}<br>
",
);