@include('profile.user', ['user' => $user, 'categories' => $categories ?? collect()])
