<?php

$to = 'sophie.creaner@gmail.com';
$subject = 'New message';
$message = '
<html>
<head>
  <title>Birthday Reminders for August</title>
</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
$headers[] = 'From: Birthday Reminder <birthday@example.com>';
$headers[] = 'Cc: birthdayarchive@example.com';
$headers[] = 'Bcc: birthdaycheck@example.com';

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));

// send_mail function

/**
 * Send email with PHP (custom function)
 *
 * by Vitali Lutz 2019
 *
 * @param mixed $recipient (array, string)
 * @param mixed $sender (array, string)
 * @param string $subject
 * @param string $message
 * @param boolean $is_html
 * @return boolean
 */
function send_mail($recipient = '', $sender = '', $subject = '', $message = '', $is_html = false) {

  // Detect HTML markdown
  if (substr_count($message, '</') >= 1) {
    $is_html = true;
  }

  // Build recipient name <email> pair
  if (is_array($recipient)) {
    $recipient = '=?UTF-8?B?' . base64_encode($recipient[0]) . '?= <' . $recipient[1] . '>';
  }

  // Build sender name <email> pair
  if (is_array($sender)) {
    $sender = '=?UTF-8?B?' . base64_encode($sender[0]) . '?= <' . $sender[1] . '>';
  }

  // Determine content type
  $content_type = 'text/plain';
  if ($is_html) {
    $content_type = 'text/html';
  }

  // Subject
  $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

  // Mail headers
  $header  = 'MIME-Version: 1.0' . "\r\n";
  $header .= 'Content-type: ' . $content_type . '; charset=utf-8' . "\r\n";
  $header .= 'Content-Transfer-Encoding: base64' . "\r\n";
  $header .= 'Date: ' . date('r (T)') . "\r\n";

  $header .= 'From: ' . $sender . "\r\n";
  $header .= 'Reply-To: ' . $sender . "\r\n";

  $header .= 'X-Mailer: PHP ' . phpversion();

  if (mail($recipient, $subject, base64_encode($message), $header)) {
    return true;
  } else {
    return false;
  }
}
?>