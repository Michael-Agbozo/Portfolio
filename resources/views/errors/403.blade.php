@include('errors._layout', [
    'code' => '403',
    'eyebrow' => 'Private area',
    'title' => 'This part is off limits.',
    'message' => 'You do not have permission to view this page. If you expected access, sign in with the right account or reach out through the contact form.',
    'suggestions' => [
        'Use the login page if this is your dashboard.',
        'Head back to the public portfolio.',
        'Contact Michael if access should be restored.',
    ],
])
