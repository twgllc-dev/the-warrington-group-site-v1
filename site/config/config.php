<?php

use Kirby\Cms\App as Kirby;
use Kirby\Http\Response;

// SMTP credentials live in an untracked file (this repo is public).
// See site/config/secrets.example.php. If the file is absent, Kirby falls back
// to PHP's mail(), which is unreliable on most managed hosts.
$secretsFile = __DIR__ . '/secrets.php';
$secrets     = is_file($secretsFile) ? (require $secretsFile) : [];

return [

    // --- existing production settings (from twg-kirby-cms-workflow.md §5) ---
    'debug' => false,           // MUST be false in production
    'yaml.handler' => 'symfony',
    'url' => 'https://thewarringtongroup.com',
    'panel' => [
        'install' => false,     // only ever true briefly, during initial setup
    ],

    // --- Contact Us page: notification email settings ---
    // Submissions are saved under content/connections/ and emailed here.
    'twg.contact.to'   => 'thewarrgroupllc@gmail.com',
    'twg.contact.from' => 'noreply@thewarringtongroup.com',
    'email'            => isset($secrets['smtp']) ? ['transport' => $secrets['smtp']] : [],

    // --- "Stay in Contact" form handler for the coming-soon page ---
    'routes' => [
        [
            'pattern' => 'stay-in-contact',
            'method'  => 'POST',
            'action'  => function () {
                $kirby = kirby();
                $data  = $kirby->request()->data();

                // Honeypot: if this hidden field is filled in, silently accept
                // and drop the submission (keeps bots from knowing they failed).
                if (!empty($data['website'])) {
                    return Response::json(['status' => 'ok']);
                }

                // CSRF check
                if (!csrf($data['csrf'] ?? null)) {
                    return Response::json([
                        'status'  => 'error',
                        'message' => 'Your session expired — please refresh the page and try again.',
                    ], 403);
                }

                $firstname = trim(strip_tags($data['firstname'] ?? ''));
                $lastname  = trim(strip_tags($data['lastname']  ?? ''));
                $business  = trim(strip_tags($data['business']  ?? ''));
                $email     = trim($data['email'] ?? '');
                $phone     = trim(strip_tags($data['phone']     ?? ''));
                $details   = trim(strip_tags($data['details']   ?? ''));

                // Basic required-field + email validation
                if ($firstname === '' || $lastname === '' || $email === '') {
                    return Response::json([
                        'status'  => 'error',
                        'message' => 'Please fill in your first name, last name, and email.',
                    ], 422);
                }

                if (V::email($email) === false) {
                    return Response::json([
                        'status'  => 'error',
                        'message' => 'Please enter a valid email address.',
                    ], 422);
                }

                $leads = $kirby->page('leads');

                if ($leads === null) {
                    return Response::json([
                        'status'  => 'error',
                        'message' => 'Something went wrong on our end. Please email us directly instead.',
                    ], 500);
                }

                // Creating a page normally requires an authenticated user, so we
                // briefly impersonate the system "kirby" user for this one action.
                $kirby->impersonate('kirby', function () use ($leads, $firstname, $lastname, $business, $email, $phone, $details) {
                    $leads->createChild([
                        'slug'     => 'lead-' . date('Ymd-His') . '-' . substr(bin2hex(random_bytes(3)), 0, 6),
                        'template' => 'lead',
                        'content'  => [
                            'firstname' => $firstname,
                            'lastname'  => $lastname,
                            'business'  => $business,
                            'email'     => $email,
                            'phone'     => $phone,
                            'details'   => $details,
                            'date'      => date('Y-m-d H:i:s'),
                        ],
                    ])->changeStatus('unlisted');
                });

                return Response::json(['status' => 'ok']);
            },
        ],
    ],

];
