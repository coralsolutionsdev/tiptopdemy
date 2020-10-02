<?php
/**
 * Admin
 */

/**
 * Front end
 */

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('main._home'), route('main'));
});
/*store*/
// Home > Blog
Breadcrumbs::for('store', function ($trail) {
    $trail->parent('home');
    $trail->push(__('main.Store'), route('store.products.main'));
});
// Home > Blog >
Breadcrumbs::for('cart', function ($trail) {
    $trail->parent('store');
    $trail->push(__('main.Cart'), route('cart.index'));
});

// Home > Profile
Breadcrumbs::for('profile', function ($trail) {
    $trail->parent('home');
    $trail->push(__('main.Profile'), route('profile.index'));
});
// Home > Profile > My Courses
Breadcrumbs::for('courses', function ($trail) {
    $trail->parent('profile');
    $trail->push(__('main.My Courses'), route('profile.courses.index'));
});
// Home > Profile > Edit
Breadcrumbs::for('profile.edit', function ($trail, $user) {
    $trail->parent('profile');
    $trail->push(__('main.Edit Profile'), route('profile.edit', $user->id));
});
// Home > Profile > My orders
Breadcrumbs::for('orders', function ($trail) {
    $trail->parent('profile');
    $trail->push(__('main.My Orders'), route('profile.orders.index'));
});
// Home > Profile > My Observers List
Breadcrumbs::for('observers', function ($trail) {
    $trail->parent('profile');
    $trail->push(__('main.Observers List'), route('profile.observers.index'));
});
/**
 * Blog
 */
// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
    $trail->parent('home');
    $trail->push(__('main.Blog'), route('blog.posts.main'));
});
// Home > Blog > Post
Breadcrumbs::for('blog.post.show', function ($trail, $post) {
    $trail->parent('blog');
    $trail->push($post->title, route('blog.posts.show', $post->slug));
});
// Home > Blog > [Category]
Breadcrumbs::for('blog.category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->name, route('blog.category.show', $category->slug));
});
//// Home > Blog > [Category] > [Post]
//Breadcrumbs::for('post', function ($trail, $post) {
//    $trail->parent('category', $post->category);
//    $trail->push($post->title, route('post', $post->id));
//});