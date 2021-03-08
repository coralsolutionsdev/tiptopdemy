<div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-remove" uk-sticky="offset: 25; bottom: #offset">
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_SECTION}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main._form_section')}}</p>
                    <p class="font-weight-light m-0">{{__('main.Create new questions group')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_SHORT_ANSWER}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main.Short answer')}}</p>
                    <p class="font-weight-light m-0">{{__('main.For single line text fields')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_PARAGRAPH}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main.Open end Answer')}}</p>
                    <p class="font-weight-light m-0">{{__('main.For paragraph text fields')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_SINGLE_CHOICE}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main.Single choice')}}</p>
                    <p class="font-weight-light m-0">{{__('main.Ratio allowing one choice')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_MULTI_CHOICE}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main.Multiple choice')}}</p>
                    <p class="font-weight-light m-0">{{__('main.Allowing multi choice')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_DROP_DOWN}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main.Drop menu')}}</p>
                    <p class="font-weight-light m-0">{{__('main.To select from menu')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main.Fill the blank')}}</p>
                    <p class="font-weight-light m-0">{{__('main.Fill the blank question')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class=" uk-grid-medium" uk-grid>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="uk-width-expand@m uk-flex uk-flex-middle">
                <div>
                    <p class="font-weight-bold m-0">{{__('main.Fill the blank (drag and drop)')}}</p>
                    <p class="font-weight-light m-0">{{__('main.Fill the blank question')}}.</p>
                </div>
            </div>
            <div class="uk-width-auto@m uk-text-center uk-flex uk-flex-middle">
                <span class="count">0</span>
            </div>
        </div>
    </div>

</div>