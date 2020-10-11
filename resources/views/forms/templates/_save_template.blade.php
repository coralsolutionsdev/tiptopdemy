<!-- Modal -->
@if(!empty($form))
<div class="modal fade" id="saveAsTemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::open(['url' => route('form.template.clone'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'id' => 'clone-form']) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('main.save as Template')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="{{\App\Modules\Form\Form::TYPE_FORM_TEMPLATE}}">
                <input type="hidden" name="form_template_id" value="{{$form->id}}">
                <div>
                    <div class="row uk-margin-small">
                        <div class="col-2 uk-flex uk-flex-middle">
                            {{__('main.Title')}}:
                        </div>
                        <div class="col-10">
                            <input class="uk-input uk-form-small" name="title" type="text" value="{{!empty($form->title) ? $form->title : 'untitled quiz'}}">
                        </div>
                    </div>
                    @if(!empty($categories))
                        <div class="row uk-margin-small" uk-grid>
                            <div class="col-2 uk-flex uk-flex-middle">
                                {{__('main.categories')}}:
                            </div>
                            <div class="col-10">
                                <div style="max-height: 300px; overflow: scroll; overflow-x: hidden">
                                    {{drawInputTreeListItems($categories, 'categories[]',!empty($selectedCategories) ? $selectedCategories : array(), 'checktree')}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button class="uk-button uk-button-primary">{{__('main.Save')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif