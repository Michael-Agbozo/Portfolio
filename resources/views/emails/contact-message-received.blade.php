<p>You received a new message from your portfolio website.</p>

<p>
  <strong>Name:</strong> {{ $contactMessage->name }}<br>
  <strong>Email:</strong> {{ $contactMessage->email }}<br>
  <strong>Subject:</strong> {{ $contactMessage->subject }}
</p>

<p><strong>Message:</strong></p>

<p style="white-space:pre-line">{{ $contactMessage->message }}</p>

<p>Reply to this email to respond directly to {{ $contactMessage->name }}.</p>
