@include('errors._layout', [
    'code' => '419',
    'eyebrow' => 'Session expired',
    'title' => 'The page got stale.',
    'message' => 'For your security, the form session expired. Refresh the page and try again; your message should send normally after that.',
    'suggestions' => [
        'Refresh the page before resubmitting.',
        'Copy long messages before trying again.',
        'Use WhatsApp if the form keeps expiring.',
    ],
])
