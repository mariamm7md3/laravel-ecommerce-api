<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #333;">

<p>Hi {{ $userMessage->user->first_name }},</p>

<p>Thank you for reaching out. Here's our reply to your message:</p>

<blockquote style="border-left: 3px solid #ccc; padding-left: 12px; color: #666;">
    {{ $replyBody }}
</blockquote>

<hr>

<p style="color: #999; font-size: 13px;">
    <strong>Your original message:</strong><br>
    {{ $userMessage->title }}<br>
    {{ $userMessage->body }}
</p>

</body>
</html>
