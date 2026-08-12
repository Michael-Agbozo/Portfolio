@include('errors._layout', [
    'code' => '500',
    'eyebrow' => 'Server error',
    'title' => 'Something broke behind the scenes.',
    'message' => 'The site hit an unexpected issue. Try again shortly, or use the contact link if the problem keeps happening.',
    'suggestions' => [
        'Refresh once after a short wait.',
        'Try another portfolio page.',
        'Report the issue through contact.',
    ],
])
