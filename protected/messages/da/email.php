<?php
return array(
    "Email has been sent" => "Email blev afsendt",
    "Banner or TextLink"=>"Banner eller TekstLink",
    "Contact Form"=>"Kontakt formular",

    // Subject's
    "Email Subject Approved Regular" => "{BrandName}: Tillykke. Din URL er nu godkendt!",
    "Email Subject Approved Premium" => "{BrandName}: Tillykke. Din URL er nu godkendt!",

    "Email Subject Rejected Regular" => "{BrandName}: Desværre, din indsendte URL blev afvist.",
    "Email Subject Rejected Premium" => "{BrandName}: Desværre, din indsendte URL blev afvist.",

    "Email Subject Waiting Regular" => "{BrandName}: Vigtig information om indsendelse af hjemmesider",
    "Email Subject Waiting Premium" => "{BrandName}: Vigtig information om indsendelse af hjemmesider",


    // Free approved
    "Email Body Approved Regular" => "Hej {Username},<br><br>
Vi er glade for at meddele dig , at dit websted \"{Title}\" er opført i {HomeUrl}<br><br>
Titel: {Title}<br>
Kategori: {CategoryPath}<br>
URL: {Link}<br><br>
For at fjerne nofollow fra din url , skal du placere {Banner or TextLink} og derefter kontakte os via {ContactForm}.
<br><br>
Med venlig hilsen,<br>
folkene bag {HomeUrl}<br>
",

    // Premium approved
    "Email Body Approved Premium" => "Hej {Username},<br><br>
Vi er glade for at meddele dig , at dit websted \"{Title}\" er opført i {HomeUrl}<br><br>
Titel: {Title}<br>
Kategori: {CategoryPath}<br>
URL: {Link}<br><br> 
Med venlig hilsen,<br>
Folkene bag {HomeUrl}<br>
",

    // Free waiting
    "Email Body Waiting Regular" => "Hej {Username},<br><br>
Tak for din indsendelse af \"{Title}\" til {HomeUrl}<br>
På grund af stor mængde af links, kan det tage så lang tid som 1 måned eller mere , for at gennemgå din hjemmeside inden godkendelse .
( Indsendelser bliver behandlet først til mølle ).<br><br>
For at fjerne nofollow fra din url , skal du placere {Banner or TextLink} og derefter kontakte os via {ContactForm}. <br><br>
Med venlig hilsen,<br>
Folkene bag {HomeUrl}<br>
",

    // Premium waiting
    "Email Body Waiting Premium" => "Hej {Username},<br><br>
Tak for din indsendelse af \"{Title}\" til {HomeUrl}<br><br>
Med venlig hilsen,<br>
Folkene bag {HomeUrl}<br>
",

    // Free rejected
    "Email Body Rejected Regular" => "Hej {Username},<br><br>
Vi er nødt til at skuffe dig , men dit indsendte link:<br>
{Url}<br>
er blevet afvist.<br><br>
Med venlig hilsen,<br>
Folkene bag {HomeUrl}<br>
",

    // Premium rejected
    "Email Body Rejected Premium" => "Hej {Username},<br><br>
Vi er nødt til at skuffe dig , men dit indsendte link:<br>
{Url}<br>
er blevet afvist.<br><br>
Med venlig hilsen,<br>
Folkene bag {HomeUrl}<br>
",
);