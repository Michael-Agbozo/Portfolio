@include('errors._layout', [
    'code' => '404',
    'eyebrow' => 'Page not found',
    'title' => 'This page slipped out of frame.',
    'message' => 'The link may be old, moved, or mistyped. The homepage and selected work are still right where they should be.',
    'suggestions' => [
        'Check the address for a typo.',
        'Browse the latest selected work.',
        'Use contact if a shared link is broken.',
    ],
])
