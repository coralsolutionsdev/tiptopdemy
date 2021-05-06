<?php
/**
 * Admin
 */

/**
 * Front end
 */

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
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
// Home > Store > category
Breadcrumbs::for('store.category', function ($trail, $category) {
    $trail->parent('store');
    $trail->push($category->name, route('store.category.show', $category->slug));
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
// Home > Store > Lesson > quiz
Breadcrumbs::for('store.product.lesson.quiz', function ($trail, $lesson, $form) {
    $trail->parent('store.product.lesson', $lesson);
    $trail->push($form->title, route('store.form.show',[$lesson->slug, $form->hash_id]));
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


/***************
 * Admin panel
 ***************/
//  Store
Breadcrumbs::for('admin.store', function ($trail) {
    $trail->push(__('main.Products'), route('store.products.index'));
});
//  Store > create
Breadcrumbs::for('admin.store.create', function ($trail) {
    $trail->parent('admin.store');
    $trail->push(__('main.Create'), route('store.products.create'));
});
//  Store > product name > edit
Breadcrumbs::for('admin.store.edit', function ($trail, $product) {
    $trail->parent('admin.store');
    $trail->push($product->name, route('store.products.edit', $product->slug));
    $trail->push(__('main.Edit'));
});
//  Store > product name > Group > new
Breadcrumbs::for('admin.store.groups.create', function ($trail, $product) {
    $trail->parent('admin.store');
    $trail->push($product->name, route('store.products.edit', $product->slug));
    $trail->push(__('main.Units'), route('store.groups.create', $product->slug));
    $trail->push(__('main.Create'));
});
//  Store > product name > Group > edit
Breadcrumbs::for('admin.store.groups.edit', function ($trail, $product, $group) {
    $trail->parent('admin.store');
    $trail->push($product->name, route('store.products.edit', $product->slug).'#lessons');
    $trail->push($group->title, route('store.groups.edit', [$product->slug, $group->slug]));
    $trail->push(__('main.Edit'));
});
//  Store > product name > Lesson > new
Breadcrumbs::for('admin.store.lesson.create', function ($trail, $product) {
    $trail->parent('admin.store');
    $trail->push($product->name, route('store.products.edit', $product->slug));
    $trail->push(__('main.Lessons'), route('store.lessons.create', $product->slug));
    $trail->push(__('main.Create'));
});
//  Store > product name > Lesson > edit
Breadcrumbs::for('admin.store.lesson.edit', function ($trail, $product, $currentGroup, $lesson) {
    $trail->parent('admin.store');
    $trail->push($product->name, route('store.products.edit', $product->slug).'#lessons');
    $trail->push($currentGroup->title, route('store.groups.edit', [$product->slug, $currentGroup->slug]));
    $trail->push($lesson->title, route('store.lessons.edit', [$product->slug, $lesson->slug]));
    $trail->push(__('main.Edit'));
});
//  Forms > Memorize > create
Breadcrumbs::for('admin.store.memorize.create', function ($trail, $product, $lesson) {
    $trail->parent('admin.store');
    $trail->push($lesson->title, route('store.lessons.edit', [$product->slug, $lesson->slug]));
    $trail->push(__('main.Memory Test'));
    $trail->push(__('main.Create'));
});
//  Forms > Memorize > edit
Breadcrumbs::for('admin.store.memorize.edit', function ($trail, $product, $lesson, $form) {
    $trail->parent('admin.store');
    $trail->push($lesson->title, route('store.lessons.edit', [$product->slug, $lesson->slug]));
    $trail->push($form->title, route('store.memorize.edit', [$lesson->slug, $form->hash_id]));
    $trail->push(__('main.Edit'));
});