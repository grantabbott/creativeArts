<?php return array (
  'forgot_password' => 
  array (
    'category' => 'system',
    'title' => 'Forgot Passwords',
    'fields' => 'NAME, USERNAME, EMAIL, LINK',
  ),
  'activation_mail' => 
  array (
    'category' => 'system',
    'title' => 'Activation Mails',
    'fields' => 'USERNAME, EMAIL, LINK',
  ),
  'new_user' => 
  array (
    'category' => 'system',
    'title' => 'New User Registered [USERNAME]',
    'fields' => 'USERNAME, EMAIL, PASSWORD, DEPARTMENT',
  ),
  'new_ticket' => 
  array (
    'category' => 'system',
    'title' => 'New Ticket Generated Ticket # [TICKET_NO]',
    'fields' => 'TICKET_NO, DEPARTMENT, TICKET_SUBJECT, TICKET_STATUS, TICKET_PRIORITY, TICKET_TYPE, USERNAME, NAME, EMAIL, RESPONSE_TIME, RESOLUTION_TIME',
  ),
);