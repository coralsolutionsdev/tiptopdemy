<div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-remove" uk-sticky="offset: 25; bottom: #offset">
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_SECTION}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center"><i class="fas fa-grip-lines"></i></div>
            <div class="col-lg-10">
                <p class="font-weight-bold m-0">{{__('main.Section')}}</p>
                <p class="font-weight-light m-0">{{__('main.Create new section')}}.</p>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_SHORT_ANSWER}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center"><i class="fas fa-pen"></i></div>
            <div class="col-lg-10">
                <p class="font-weight-bold m-0">{{__('main.Short text')}}</p>
                <p class="font-weight-light m-0">{{__('main.For single line text fields')}}.</p>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_PARAGRAPH}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center"><i class="fas fa-align-left"></i></div>
            <div class="col-lg-10">
                <p class="font-weight-bold m-0">{{__('main.Long text')}}</p>
                <p class="font-weight-light m-0">{{__('main.For paragraph text fields')}}.</p>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_SINGLE_CHOICE}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center"><i class="far fa-dot-circle"></i></div>
            <div class="col-lg-10">
                <p class="font-weight-bold m-0">{{__('main.Single choice')}}</p>
                <p class="font-weight-light m-0">{{__('main.Ratio allowing one choice')}}.</p>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_MULTI_CHOICE}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center"><i class="far fa-check-square"></i></div>
            <div class="col-lg-10">
                <p class="font-weight-bold m-0">{{__('main.Multiple choice')}}</p>
                <p class="font-weight-light m-0">{{__('main.Allowing multi choice')}}.</p>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_DROP_DOWN}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center"><i class="fas fa-server"></i></div>
            <div class="col-lg-10">
                <p class="font-weight-bold m-0">{{__('main.Drop menu')}}</p>
                <p class="font-weight-light m-0">{{__('main.To select from menu')}}.</p>
            </div>
        </div>
    </div>
    {{--question item--}}
    <div id="questionType-{{\App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK}}" class="question-type card card-body border-hover-primary pt-2 pb-2 m-2">
        <div class="row">
            <div class="col-lg-2 d-flex align-items-center"><i class="far fa-square"></i></div>
            <div class="col-lg-10">
                <p class="font-weight-bold m-0">{{__('main.Fill the blank')}}</p>
                <p class="font-weight-light m-0">{{__('main.Fill the blank question')}}.</p>
            </div>
        </div>
    </div>
</div>