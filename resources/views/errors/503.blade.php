@include('errors._layout', [
    'code' => '503',
    'eyebrow' => 'Temporarily unavailable',
    'title' => 'The site is taking a short pause.',
    'message' => 'Maintenance or a temporary server issue is blocking the page. Please check again in a few minutes.',
    'suggestions' => [
        'Check back in a few minutes.',
        'Avoid submitting forms during maintenance.',
        'Use WhatsApp for urgent contact.',
    ],
])
