@include('errors._layout', [
    'code' => '500',
    'eyebrow' => 'Server error',
    'title' => 'Something broke behind the scenes.',
    'message' => 'The site hit an unexpected issue. Try again shortly, or use the contact link if the problem keeps happening.',
])
