<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mail Driver
    |--------------------------------------------------------------------------
    |
    | Laravel supports both SMTP and PHP's "mail" function as drivers for the
    | sending of e-mail. You may specify which one you're using throughout
    | your application here. By default, Laravel is setup for SMTP mail.
    |
    | Supported: "smtp", "mail", "sendmail", "mailgun", "mandrill",
    |            "ses", "sparkpost", "log"
    |
    */

    'driver'        => env('MAIL_DRIVER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Address
    |--------------------------------------------------------------------------
    |
    | Here you may provide the host address of the SMTP server used by your
    | applications. A default option is provided that is compatible with
    | the Mailgun mail service which will provide reliable deliveries.
    |
    */
    'host'          => env('MAIL_HOST', 'email-smtp.us-east-1.amazonaws.com'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Host Port
    |--------------------------------------------------------------------------
    |
    | This is the SMTP port used by your application to deliver e-mails to
    | users of the application. Like the host we have set this value to
    | stay compatible with the Mailgun e-mail application by default.
    |
    */
    'port'          => env('MAIL_PORT', 587),

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */
    'from'          => ['address' => 'support@tecdonor.com', 'name' => 'Tecdonor'],

    /*
    |--------------------------------------------------------------------------
    | E-Mail Encryption Protocol
    |--------------------------------------------------------------------------
    |
    | Here you may specify the encryption protocol that should be used when
    | the application send e-mail messages. A sensible default using the
    | transport layer security protocol should provide great security.
    |
    */
    'encryption'    => env('MAIL_ENCRYPTION', 'tls'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Server Username
    |--------------------------------------------------------------------------
    |
    | If your SMTP server requires a username for authentication, you should
    | set it here. This will get used to authenticate with your server on
    | connection. You may also set the "password" value below this one.
    |
    */
    'username'      => env('MAIL_USERNAME'),

    /*
    |--------------------------------------------------------------------------
    | SMTP Server Password
    |--------------------------------------------------------------------------
    |
    | Here you may set the password required by your SMTP server to send out
    | messages from your application. This will be given to the server on
    | connection so that the application will be able to send messages.
    |
    */
    'password'      => env('MAIL_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Sendmail System Path
    |--------------------------------------------------------------------------
    |
    | When using the "sendmail" driver to send e-mails, we will need to know
    | the path to where Sendmail lives on this server. A default path has
    | been provided here, which will work well on most of your systems.
    |
    */
    'sendmail'      => '/usr/sbin/sendmail -bs',

    /*
    |--------------------------------------------------------------------------
    | Custom emails settings
    |--------------------------------------------------------------------------
    */
    'custom_emails' => [
        'common_variables' => [
            'recipient_email',
            'organization_name',
            'organization_email',
            'organization_location',
        ],
        'templates'        => [
            [
                'key'       => 'invitation_to_employees',
                'title'     => 'Invitation to employees',
                'subject'   => 'You\'re invited to join {organization_name} on Tecdonor',
                'body'      => <<<EOT
You're invited to join {organization_name} on Tecdonor

Hi there!
You have been invited to join the {organization_name} team on Tecdonor.
Tecdonor is the first rewards program for volunteers. With every hour you contribute to a nonprofit organization, you earn reward points which can be spent with our corporate partners or donated back to a nonprofit.
Also, as a member of the {organization_name} team, your account is completely free! Please click the button below to get started.
{accept_button}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'invitation_accept_button',
                ],
            ],
            [
                'key'       => 'invitation_to_shift',
                'title'     => 'Invitation to shift',
                'subject'   => 'You\'re invited to join the shift: {event_title} on Tecdonor',
                'body'      => <<<EOT
You're invited to join the shift: {event_title} on Tecdonor

Hi there!
You have been invited to join the shift: {event_title}
The shifts starts at: {shift_start_time}
The shifts ends at: {shift_end_time}
{event_view_button}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'event_title',
                    'event_view_button',
                    'shift_start_time',
                    'shift_end_time',
                ],
            ],
            [
                'key'       => 'invitation_to_volunteers',
                'title'     => 'Invitation to volunteers',
                'subject'   => 'You\'re invited to join {organization_name} on Tecdonor',
                'body'      => <<<EOT
You're invited to join {organization_name} on Tecdonor

Hi there!
You have been invited to join as a volunteer with {organization_name} on Tecdonor.
Tecdonor is the first rewards program for volunteers.  With every hour you volunteer with a nonprofit organization, you earn rewards points which can be spent with our corporate partners or donated back to a nonprofit.
Please accept the invitation to get started for free!
{accept_button}
If you have any questions, please contact {organization_name} at {organization_email}. 

&mdash; Your Tecdonor Team
EOT
                ,
                'variables' => [
                    'invitation_accept_button',
                ],
            ],
            [
                'key'       => 'opportunity_application_accepted',
                'title'     => 'Opportunity application accepted',
                'subject'   => 'Your application to {opportunity_title} has been accepted!',
                'body'      => <<<EOT
Your application to {opportunity_title} has been accepted!

Hi {recipient_name},
Congrats! {organization_name} has accepted your application to {opportunity_title}.
{opportunity_view_button}

Your pin for check-in/check-out: {volunteer_pin}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'recipient_name',
                    'opportunity_title',
                    'opportunity_view_button',
                    'volunteer_pin',
                ],
            ],
            [
                'key'       => 'opportunity_application_rejected',
                'title'     => 'Opportunity application rejected',
                'subject'   => 'Your application to {opportunity_title} has been rejected!',
                'body'      => <<<EOT
Your application to {opportunity_title} has been rejected!

Hi {recipient_name}!
Unfortunately, {organization_name} has rejected your application to {opportunity_title}.
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'opportunity_title',
                    'recipient_name',
                ],
            ],
            [
                'key'       => 'opportunity_check_in',
                'title'     => 'Opportunity check in',
                'subject'   => 'You have successfully check-in for Opportunity {opportunity_title}',
                'body'      => <<<EOT
You have successfully check-in for Opportunity {opportunity_title}

Hi {recipient_name},
You have successfully check-in for Opportunity {opportunity_title}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'opportunity_title',
                    'recipient_name',
                ],
            ],
            [
                'key'       => 'opportunity_check_out',
                'title'     => 'Opportunity check out',
                'subject'   => 'You have successfully check-out for Opportunity {opportunity_title}',
                'body'      => <<<EOT
You have successfully check-out for Opportunity {opportunity_title}

Hi {recipient_name},
You have successfully check-out for Opportunity {opportunity_title}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'opportunity_title',
                    'recipient_name',
                ],
            ],
            [
                'key'       => 'group_application_approvement',
                'title'     => 'Group application approvement',
                'subject'   => 'You\'re invited to join: {event_title}',
                'body'      => <<<EOT
You're invited to join: {event_title}

Hi there!
Please confirm by accepting the invitation to join: '{event_title}'
Shift starts: {shift_start_time}
Shift ends: {shift_end_time}
{event_view_button}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'event_title',
                    'event_view_button',
                    'shift_start_time',
                    'shift_end_time',
                    'recipient_name',
                ],
            ],
            [
                'key'       => 'group_application_revoke',
                'title'     => 'Group application revoke',
                'subject'   => 'Your invitation to {opportunity_title} has been revoked',
                'body'      => <<<EOT
Your invitation to {opportunity_title} has been revoked

Hi there!
Your invitation to {opportunity_title} has been revoked
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'opportunity_title',
                    'recipient_name',
                ],
            ],
            [
                'key'       => 'opportunity_archived',
                'title'     => 'Opportunity archived',
                'subject'   => 'Opportunity has been archived by nonprofit',
                'body'      => <<<EOT
Opportunity has been archived by nonprofit.

Hi there!
Opportunity has been archived by nonprofit.
This means all of your applications to this opportunity was canceled.
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'opportunity_title',
                    'recipient_name',
                ],
            ],
            [
                'key'       => 'opportunity_shift_assigned',
                'title'     => 'Opportunity shift assigned',
                'subject'   => 'You were assigned to the shift {event_title} at {opportunity_title}',
                'body'      => <<<EOT
You were assigned to the shift {event_title} at {opportunity_title}

Hi {recipient_name},
You were assigned to the shift {event_title} at {opportunity_title}
{event_view_button}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'opportunity_title',
                    'event_title',
                    'event_view_button',
                    'recipient_name',
                ],
            ],
            [
                'key'       => 'shift_application_reminder',
                'title'     => 'Shift application reminder',
                'subject'   => 'Your shift {event_title} will start in less then {event_number_of_days} days',
                'body'      => <<<EOT
Your shift {event_title} will start in less then {event_number_of_days} days

Hi there!
Your shift {event_title} will start in less then {event_number_of_days} days
Your pin for check-in/check-out: {volunteer_pin}
If you have any questions, please reply to this email.

&mdash; The Tecdonor Team
EOT
                ,
                'variables' => [
                    'event_title',
                    'event_number_of_days',
                    'volunteer_pin',
                    'recipient_name',
                ],
            ],
        ],
    ],
];
