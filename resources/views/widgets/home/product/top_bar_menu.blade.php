<div class="filter-section uk-card uk-card-default uk-card-body" style="padding: 25px">
    <form action="{{ route('store.products.main') }}" method="GET" class="search">
    <div class="uk-grid-small" uk-grid>
        <div class="input-group uk-width-expand">
            <div class="item-title">
                <span class="title">{{__('main.Search in store')}}</span>
            </div>
            <input class="uk-input" name="search" type="text" placeholder="" value="{{ $_GET['search'] ?? '' }}">
        </div>
        <div class="uk-width-auto">
            <button class="uk-button uk-button-primary" style="padding:0px 15px">
                <span uk-icon="icon: search"></span>
            </button>
        </div>

        <div class="input-group uk-width-expand">
            <div class="item-title">
                <span class="title">{{__('main.Filter by Category')}}</span>
            </div>
            <select name="category" class="uk-select" id="form-stacked-select uk-form-small">
                <option value="0">أختر التصنيف</option>
                @foreach($categories as $id => $name)
                <option value="{{$id}}" {{(!empty($_GET['category']) && $_GET['category'] == $id) ? 'selected' : ''}}>{{$name}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group uk-width-expand">
            <div class="item-title">
                <span class="title">{{__('main.Sort by')}}</span>
            </div>
            <select name="sort" class="uk-select" id="form-stacked-select uk-form-small">
                <option>{{__('main.Default Sort')}}</option>
                <option>{{__('main.Sort by name')}}</option>
                <option>{{__('main.Sort by position')}}</option>
                <option>{{__('main.Price low to high')}}</option>
                <option>{{__('main.Price high to low')}}</option>
            </select>
        </div>
        <div class="uk-width-auto">
            <button class="uk-button uk-button-primary" style="padding:0px 25px">{{__('main.Apply Filter')}}</button>
        </div>
    </div>
    </form>
</div>
