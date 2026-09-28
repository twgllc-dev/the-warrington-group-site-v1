<?php

/**
 * Copy this file to `secrets.php` on the server (SFTP/SSH) and fill it in.
 * `secrets.php` is git-ignored — never commit real credentials to this public repo.
 *
 * Any SMTP provider works. Two easy options:
 *
 * A) Gmail (thewarrgroupllc@gmail.com): turn on 2-Step Verification, then create an
 *    App Password at https://myaccount.google.com/apppasswords and use it below.
 *    Gmail rewrites the "From" address to the authenticated account; that's fine.
 *
 * B) A transactional sender (Postmark, Resend, SendGrid, Amazon SES). Better
 *    deliverability from noreply@thewarringtongroup.com once SPF/DKIM are set up.
 */
return [
    'smtp' => [
        'type'     => 'smtp',
        'host'     => 'smtp.gmail.com',
        'port'     => 587,
        'security' => true,          // Kirby picks TLS for 587, SSL for 465
        'auth'     => true,
        'username' => 'thewarrgroupllc@gmail.com',
        'password' => 'xxxx xxxx xxxx xxxx',
    ],
];
