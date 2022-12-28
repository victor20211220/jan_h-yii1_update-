<?php
return array(
    'Email has been sent' => 'Email wurde versendet',
    'Banner or TextLink' => 'Banner oder Textlink',
    'Contact Form' => 'Kontaktformular',
    'Email Subject Approved Regular' => '{BrandName}: Gratulation. Ihre URL ist genemigt worden!',
    'Email Subject Approved Premium' => '{BrandName}: Gratulation. Ihre URL ist genemigt worden!',
    'Email Subject Rejected Regular' => '{BrandName}: Leider wurde Ihre eingereichte URL nicht genemigt.',
    'Email Subject Rejected Premium' => '{BrandName}: Leider wurde Ihre eingereichte URL nicht genemigt.',
    'Email Subject Waiting Regular' => '{BrandName}: Wichtige Nachricht über die Seiteneinreichung',
    'Email Subject Waiting Premium' => '{BrandName}: Wichtige Nachricht über die Seiteneinreichung',
    // Free approved
    "Email Body Approved Regular" => "Hallo {Username},<br><br>
Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Website \"{Title}\" in {HomeUrl} gelistet ist.<br><br>
Titel: {Title}<br>
Kategorie: {CategoryPath}<br>
URL: {Link}<br><br>
Um nofollow aus Ihrer URL zu entfernen, müssen Sie {Banner or TextLink} platzieren und uns dann über {ContactForm} kontaktieren.
<br><br>
Freundliche Grüße,<br>
{HomeUrl} Team<br>
",

    // Premium approved
    "Email Body Approved Premium" => "Hallo {Username},<br><br>
Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Website \"{Title}\" in {HomeUrl} gelistet ist.<br><br>
Titel: {Title}<br>
Kategorie: {CategoryPath}<br>
URL: {Link}<br><br>
Freundliche Grüße,<br>
{HomeUrl} Team<br>
",

    // Free waiting
    "Email Body Waiting Regular" => "Hallo {Username},<br><br>
Vielen Dank für Ihre Übermittlung von \"{Title}\" an {HomeUrl}.<br>
Aufgrund des großen Pools an kostenlosen Einreichungen kann es bis zu 1 Monat oder länger dauern, bis Ihre Website auf Aufnahme überprüft wird.
(In der Reihenfolge überprüft, in der es eingegangen ist).<br><br>
Um nofollow aus Ihrer URL zu entfernen, müssen Sie {Banner or TextLink} platzieren und uns dann über {ContactForm} kontaktieren.<br><br>
Freundliche Grüße,<br>
{HomeUrl} Team<br>
",
    // Premium waiting
    "Email Body Waiting Premium" => "Hallo {Username},<br><br>
Vielen Dank für Ihre Übermittlung von \"{Title}\" an {HomeUrl}.<br><br>
Freundliche Grüße,<br>
{HomeUrl} Team<br>",

    // Free rejected
    "Email Body Rejected Regular" => "Hallo {Username},<br><br>
Wir müssen Sie enttäuschen, aber Ihr eingereichter Link:<br>
{Url}<br>
wurde abgelehnt.<br><br>
Freundliche Grüße,<br>
{HomeUrl} Team<br>
",

    // Premium rejected
    "Email Body Rejected Premium" => "Hallo {Username},<br><br>
Wir müssen Sie enttäuschen, aber Ihr eingereichter Link:<br>
{Url}<br>
wurde abgelehnt.<br><br>
Freundliche Grüße,<br>
{HomeUrl} Team<br>
",
);