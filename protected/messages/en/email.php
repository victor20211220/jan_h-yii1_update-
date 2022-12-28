<?php
return array(
    "Email has been sent" => "Email has been sent",
    "Banner or TextLink"=>"Banner or TextLink",
    "Contact Form"=>"Contact Form",

    // Subject's
    "Email Subject Approved Regular" => "{BrandName}: Congratulation. Your URL has been approved!",
    "Email Subject Approved Premium" => "{BrandName}: Congratulation. Your URL has been approved!",

    "Email Subject Rejected Regular" => "{BrandName}: Unfortunately your submitted URL has been rejected.",
    "Email Subject Rejected Premium" => "{BrandName}: Unfortunately your submitted URL has been rejected.",

    "Email Subject Waiting Regular" => "{BrandName}: Important Note About Site Submission",
    "Email Subject Waiting Premium" => "{BrandName}: Important Note About Site Submission",


    // Free approved
    "Email Body Approved Regular" => "Dear {Username},<br><br>
We are pleased to announce you that your site \"{Title}\" listed in {HomeUrl}<br><br>
Title: {Title}<br>
Category: {CategoryPath}<br>
URL: {Link}<br><br>
To remove nofollow from your url, you need to place {Banner or TextLink} and then contact us via {ContactForm}.
<br><br>
Best Regards,<br>
{HomeUrl} Team<br>
",

    // Premium approved
    "Email Body Approved Premium" => "Dear {Username},<br><br>
We are pleased to announce you that your site \"{Title}\" listed in {HomeUrl}<br><br>
Title: {Title}<br>
Category: {CategoryPath}<br>
URL: {Link}<br><br>
Best Regards,<br>
{HomeUrl} Team<br>
",

    // Free waiting
    "Email Body Waiting Regular" => "Dear {Username},<br><br>
Thank you for your submission of \"{Title}\" to {HomeUrl}<br>
Due to large pool of free submissions, it can take as long as 1 month or more, to review your website for inclusion.
(Reviewed in the order it was received).<br><br>
To remove nofollow from your url, you need to place {Banner or TextLink} and then contact us via {ContactForm}.<br><br>
Best Regards,<br>
{HomeUrl} Team<br>
",
    // Premium waiting
    "Email Body Waiting Premium" => "Dear {Username},<br><br>
Thank you for your submission of \"{Title}\" to {HomeUrl}<br><br>
Best Regards,<br>
{HomeUrl} Team<br>",

    // Free rejected
    "Email Body Rejected Regular" => "Dear {Username},<br><br>
We have to disappoint you, but your submitted link:<br>
{Url}<br>
has been rejected.<br><br>
Best Regards,<br>
{HomeUrl} Team<br>
",

    // Premium rejected
    "Email Body Rejected Premium" => "Dear {Username},<br><br>
We have to disappoint you, but your submitted link:<br>
{Url}<br>
has been rejected.<br><br>
Best Regards,<br>
{HomeUrl} Team<br>
",
);