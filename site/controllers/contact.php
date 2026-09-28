<?php

use Kirby\Toolkit\V;

/**
 * Contact Us — handles the form POST on the same URL (/contact), so it works
 * without JavaScript. On success we redirect (?sent=1) so a refresh can't
 * resubmit. Every submission is (1) saved as a page under content/connections/
 * and (2) emailed to twg.contact.to. If only one of those works, the visitor
 * still sees success, because the submission wasn't lost.
 */
return function ($kirby, $page) {

    $interests = ['Client - I want to discuess new/exisiting business opportunities or proposal requests (RFI/RFP).',
        'Partner - I want to explore partnership opportunities with TWG.',
        'General - General questions, information requests, etc.'];
    $form      = ['interest' => '', 'name' => '', 'email' => '', 'company' => '', 'message' => ''];
    $errors    = [];
    $sent      = get('sent') === '1';

    // Optional preselect, e.g. /contact?interest=partner
    $pre = strtolower((string)get('interest'));
    foreach ($interests as $option) {
        if (strtolower($option) === $pre) {
            $form['interest'] = $option;
        }
    }

    if ($kirby->request()->is('POST')) {

        // Honeypot: bots fill every field. Pretend it worked, store nothing.
        if (trim((string)get('website')) !== '') {
            go($page->url() . '?sent=1');
        }

        // Strip control characters; collapse whitespace on single-line fields.
        $clean = function ($value, int $max, bool $multiline = false): string {
            $value = (string)$value;
            $value = preg_replace($multiline ? '/[^\P{C}\n]/u' : '/[^\P{C}]/u', '', str_replace("\r\n", "\n", $value)) ?? '';
            $value = $multiline ? trim($value) : trim(preg_replace('/\s+/u', ' ', $value) ?? '');
            return mb_substr($value, 0, $max);
        };

        $form = [
            'interest' => $clean(get('interest'), 20),
            'name'     => $clean(get('name'), 120),
            'email'    => $clean(get('email'), 200),
            'company'  => $clean(get('company'), 160),
            'message'  => $clean(get('message'), 5000, true),
        ];

        if (csrf(get('csrf')) !== true) {
            $errors['form'] = 'Your session expired. Please try again.';
        }
        if (in_array($form['interest'], $interests, true) === false) {
            $errors['interest'] = 'Please choose an interest type.';
        }
        if ($form['name'] === '') {
            $errors['name'] = 'Please enter your name.';
        }
        if ($form['email'] === '' || V::email($form['email']) === false) {
            $errors['email'] = 'Please enter a valid email address.';
        }
        if ($form['message'] === '') {
            $errors['message'] = 'Please tell us how we can help.';
        }

        if ($errors === []) {

            $submitted = date('Y-m-d H:i:s');
            $saved     = false;
            $emailed   = false;
            $entry     = null;

            // 1) Save to the "table database" (Kirby pages under /connections)
            try {
                $parent = $kirby->page('connections');
                if ($parent !== null) {
                    $entry = $kirby->impersonate('kirby', function () use ($parent, $form, $submitted) {
                        return $parent->createChild([
                            'slug'     => 'connection-' . date('Ymd-His') . '-' . bin2hex(random_bytes(3)),
                            'template' => 'connection',
                            'content'  => [
                                'title'     => $form['name'] . ' (' . $form['interest'] . ')',
                                'interest'  => $form['interest'],
                                'name'      => $form['name'],
                                'email'     => $form['email'],
                                'company'   => $form['company'],
                                'message'   => $form['message'],
                                'submitted' => $submitted,
                                'notified'  => 'false',
                            ],
                        ])->changeStatus('unlisted');
                    });
                    $saved = true;
                }
            } catch (Throwable $e) {
                error_log('[contact] save failed: ' . $e->getMessage());
            }

            // 2) Notify by email: body is each field's header + value
            try {
                $body  = "New connection submission\n\n";
                $body .= 'Interest Type: ' . $form['interest'] . "\n";
                $body .= 'Name: ' . $form['name'] . "\n";
                $body .= 'Email: ' . $form['email'] . "\n";
                $body .= 'Company / Organization: ' . ($form['company'] !== '' ? $form['company'] : '(not provided)') . "\n";
                $body .= 'Submitted: ' . date('Y-m-d H:i:s T') . "\n";
                $body .= "Message:\n" . $form['message'] . "\n";

                $kirby->email([
                    'from'        => option('twg.contact.from'),
                    'fromName'    => 'The Warrington Group Website',
                    'to'          => option('twg.contact.to'),
                    'replyTo'     => $form['email'],
                    'replyToName' => $form['name'],
                    'subject'     => 'New connection submission: ' . $form['interest'] . ' - ' . $form['name'],
                    'body'        => $body,
                ]);
                $emailed = true;
            } catch (Throwable $e) {
                error_log('[contact] email failed: ' . $e->getMessage());
            }

            if ($emailed && $entry !== null) {
                try {
                    $kirby->impersonate('kirby', fn () => $entry->update(['notified' => 'true']));
                } catch (Throwable $e) {
                    error_log('[contact] flag update failed: ' . $e->getMessage());
                }
            }

            if ($saved || $emailed) {
                go($page->url() . '?sent=1');
            }

            $errors['form'] = 'Something went wrong on our end. Please email us directly instead.';
        }
    }

    return compact('interests', 'form', 'errors', 'sent');
};
