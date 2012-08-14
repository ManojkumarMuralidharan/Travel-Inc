<?php
 require ("mMail.inc");

 $mmail = new mMail ();

 //Set or unset verbose debugging messages, and in particular the outbound
 //data during send!
 $mmail->conf_debug (false);

 /*
 mMail supports the use of ssl:// and tls:// encrypted SMTP connections.  As
 shown in the example below.  If you want to use normal, unencrypted
 connections just use something like:

 $mmail->smtp_host = "smtp.mydomain.com"
 $mmail->smtp_port = 25;
 */
 $mmail->smtp_host = "ssl://smtp.gmail.com";
 $mmail->smtp_port = 587;
 $mmail->smtp_user = "manoj.wolfpack@gmail.com";
 $mmail->smtp_pass = "ignorance";

 $mmail->from      = "manoj.wolfpack@gmail.com";
 $mmail->subject   = "Test Message";

 //You can optionally set an arbitrary header date, otherwise mMail
 //defaults to the date at point of object instancing
 //$mmail->date      = $mmail->make_date ("2008-08-19 12:51:00 +0800");

 //Add recipient addresses
 $mmail->add_to ("manoj.salem@yahoo.com");
 $mmail->add_to ("manoj.wolfpack.com");
// $mmail->add_to ("address3@domain.com");

 //Attach file without inline zip
 $mmail->attach_file ("application/pdf", "document.pdf", file_get_contents ("document.pdf"));

 //Attach file with inline zip
 $mmail->attach_file ("application/pdf", "document.pdf", file_get_contents ("document.pdf"), true);

 //Test HTML Email with Embedded Image
 $cid = $mmail->embed_file ("image/png", "vt_logo_small.png", file_get_contents ("avatar.png"));
 $mmail->attach_html ("<html><body><p><img src=\"cid:".$cid."\" border=\"0\" style=\"float: left;\">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Quisque varius. Morbi dui. Ut consectetuer leo non tellus. Sed orci velit, suscipit eget, rutrum eget, porta in, neque. Morbi massa leo, auctor quis, auctor non, tincidunt id, odio. Nulla sollicitudin velit nec lorem. Suspendisse aliquam luctus augue. Quisque in turpis in sapien mattis placerat. Quisque eu tortor. Cras sollicitudin pellentesque arcu. Cras pulvinar. Sed egestas tortor a purus malesuada mattis. Sed lectus nisi, rutrum ut, tempor quis, congue ac, nibh. Donec malesuada imperdiet metus. Duis placerat lectus eget ante. In scelerisque sodales risus. Donec porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus quis nunc non sem scelerisque congue.</p><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Quisque varius. Morbi dui. Ut consectetuer leo non tellus. Sed orci velit, suscipit eget, rutrum eget, porta in, neque. Morbi massa leo, auctor quis, auctor non, tincidunt id, odio. Nulla sollicitudin velit nec lorem. Suspendisse aliquam luctus augue. Quisque in turpis in sapien mattis placerat. Quisque eu tortor. Cras sollicitudin pellentesque arcu. Cras pulvinar. Sed egestas tortor a purus malesuada mattis. Sed lectus nisi, rutrum ut, tempor quis, congue ac, nibh. Donec malesuada imperdiet metus. Duis placerat lectus eget ante. In scelerisque sodales risus. Donec porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus quis nunc non sem scelerisque congue.</p></body></html>");

 //Send and output copy of message to local file in eml format
 file_put_contents ("test_message.eml", $mmail->send (true));

 fwrite (STDOUT, "MESSAGE LOG:\n");
echo ($mmail->get_msglog ());

 fwrite (STDOUT, "ERRORS:\n");
 echo($mmail->get_errlog ());

 $mmail->reset ()
 ?>