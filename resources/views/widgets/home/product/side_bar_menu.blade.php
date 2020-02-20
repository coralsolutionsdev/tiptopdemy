<div class="uk-card uk-card-default uk-card-body" style="padding: 20px">
    {{--Search--}}
    <fieldset class="uk-fieldset">
        <div class="uk-margin">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip uk-text-primary" uk-icon="icon: search"></span>
                    <input class="uk-input" type="text" placeholder="Search in Blog ..">
                </div>
            </div>
        </div>
    </fieldset>
    <hr>
    {{-- Categories --}}
    <div>
        <div class="uk-background-secondary uk-light uk-text-center">
            <p class="uk-h4 uk-text-capitalize" style="padding: 8px">Categories</p>
        </div>
    </div>
    <div class="category-sidebar">
        {{drawCategoriesAccordionList($tree_categories,'uk-list uk-list-divider')}}
    </div>
    <hr>
    {{-- Categories --}}
    <div>
        <div class="uk-background-secondary uk-light uk-text-center">
            <p class="uk-h4 uk-text-capitalize" style="padding: 8px">Tags</p>
        </div>
    </div>
    <div class="blog-tags">
        <a class="uk-button uk-button-default" href="#">Tag</a>
        <a class="uk-button uk-button-default" href="#">Clearance</a>
        <a class="uk-button uk-button-default" href="#">Tag NAme</a>
        <a class="uk-button uk-button-default" href="#">Anonymous</a>
        <a class="uk-button uk-button-default" href="#">blog</a>

    </div>

</div>
