<?php

// Home
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > All Patients
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('users'));
});
//Home>Users information
Breadcrumbs::for('user.view', function ($trail, $user) {
    $trail->parent('users');
    $trail->push('UserInformation', route('user.view', $user));
});
//Home>Users information>Edit
Breadcrumbs::for('user.edit', function ($trail, $user) {
    $trail->parent('user.view', $user);
    $trail->push('Edit', route('user.edit', $user));
});
//home>users/search
Breadcrumbs::for('search', function ($trail) {
    $trail->parent('users');
    $trail->push('Search', route('search'));
});

