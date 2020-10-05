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
// Home > Store
Breadcrumbs::for('store', function ($trail) {
    $trail->parent('home');
    $trail->push(__('main.Store'), route('store.products.main'));
});
// Home > Store > card
Breadcrumbs::for('cart', function ($trail) {
    $trail->parent('store');
    $trail->push(__('main.Cart'), route('cart.index'));
});
//// Home > Store > [Product] > [Lesson]
//Breadcrumbs::for('product', function ($trail, $product) {
//    $trail->parent('store');
//    $trail->push($product->title, route('post', $product->slug));
//});
// Home > Store > Lesson
Breadcrumbs::for('store.product', function ($trail, $product) {
    $trail->parent('store');
    $trail->push($product->name, route('store.product.show',$product->slug));
});
// Home > Store > Lesson
Breadcrumbs::for('store.product.lesson', function ($trail, $lesson) {
    $trail->parent('store.product', $lesson->product);
    $trail->push($lesson->title, route('store.lesson.show',[$lesson->product->slug, $lesson->slug]));
});
/**
 * profile
 */
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
