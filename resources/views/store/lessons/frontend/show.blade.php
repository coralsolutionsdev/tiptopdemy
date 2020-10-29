@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<section>
    <div class="store uk-container uk-margin-medium-bottom">
        {{--header--}}
        @include('partial.frontend._page-header')
        {{--body--}}
        <div class="uk-grid-small uk-child-width-1-1" uk-grid>
            <div>
                {{--Header--}}
                <div class="product-header uk-visible@m">
                    <div class="uk-grid-small" uk-height-match="target: > div > .uk-card; row: false" uk-grid>
                        <div class="nav-col" style="width: 5%" uk-tooltip="Previous">
                            <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#prev-form').submit()">
                                <span uk-icon="icon: chevron-{{getFloatKey('end')}}"></span>
                            </div>
                        </div>
                        <div class="uk-width-expand@m">
                            <div class="uk-card uk-card-body uk-padding-small" style="background: linear-gradient(45deg,{{str_replace(['"', '[', ']'], '', json_encode($product->getColorPattern()->gradient))}}); color: #FFFFFF">
                                <div class="uk-grid-small" uk-grid>
                                    @if(true)
                                    <div class="uk-width-auto@m uk-flex uk-flex-middle">
                                        <div class="uk-card uk-card-body uk-padding-remove">
                                            <img src="{{$product->getProductPrimaryImage()}}" alt="Paris" width="100" height="100" style="width:100px;  height:100px;  object-fit:cover; border: 7px solid rgba(255,255,255,0.4); border-radius: 5px">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="uk-width-expand@m uk-flex uk-flex-middle uk-text-{{getFloatKey('start')}}">
                                        <div class="uk-card uk-card-body uk-padding-remove product-header-body">
                                            <h4 class="uk-margin-remove uk-text-bold">{{$product->name}}</h4>
                                            <h5 class="uk-margin-remove uk-text-bold uk-light">{{$lesson->title}}</h5>
                                            <p class="uk-margin-small"><span><img class="uk-border-circle" src="{{$product->user->getProfilePicURL()}}" style="width: 20px; height: 20px; object-fit: cover"></span> <span>{{__('main.By')}}: </span> <span> {{$product->user->name}}</span></p>
                                            <div class="product-tags">
                                                @foreach($product->tagsWithType('product') as $tag)
                                                    <a class="uk-button uk-button-default" href="#">{{$tag->name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-4@m">
                                        <div class="uk-card uk-card-body uk-flex uk-flex-middle uk-padding-small uk-height-1-1" style="background-color: rgba(0,0,0,0.09)">
                                            <ul class="uk-list">
                                                <li><span uk-icon="icon: play-circle"></span> {{$product->lessons->count()}} {{__('main.lessons')}}</li>
                                                <li><span uk-icon="icon: file-text"></span> {{$product->groups->count()}} {{__('main.units')}}</li>
                                                <li><span uk-icon="icon: file-edit"></span> {{$product->lessons->where('type', \App\Modules\Course\Lesson::TYPE_QUIZ)->count()}} {{__('main.quizzes')}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-col" style="width: 5%" uk-tooltip="Next">
                            <div class="uk-card uk-card-body bg-white uk-padding-small uk-flex uk-flex-middle uk-flex-center uk-box-shadow-hover-small" style="border: 0.5px solid {{$product->getMainColorPattern()}}; color: {{$product->getMainColorPattern()}}" onclick="$('#next-form').submit()">
                                <span uk-icon="icon: chevron-{{getFloatKey('start')}}"></span>
                            </div>
                            <form id="next-form" method="GET" action="{{!empty($nextLesson) ? route('store.lesson.show', [$product->slug, $nextLesson->slug]) : route('store.lesson.show', [$product->slug, $lesson->slug])}}">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div>
                <div class="uk-grid-small" uk-grid>
                    <div class="uk-width-1-4 uk-visible@m">
                        {{--Purshase--}}
                        @if(!$product->hasPurchased())
                        <div id="{{$product->id}}" class="product uk-card uk-body uk-card-default uk-padding-small">
                            <input type="hidden" name="id" class="product-id-input" value="{{$product->id}}">
                            <input type="hidden" name="name" class="product-name-input" value="{{$product->name}}">
                            <input type="hidden" name="price" class="product-price-input" value="{{$product->price}}">
                            <input type="hidden" name="image" class="product-primary-image-input" value="{{$product->getProductPrimaryImage()}}">
                            <input type="hidden" name="sku" class="product-sku-input" value="{{$product->sku}}">
                            <div class="price uk-heading-small uk-margin-remove"><span class="uk-text-primary">$</span> {{$product->price}}</div>
                            <br>
                            <div>
                                <button class="uk-button uk-button-primary uk-width-1-1 cart-action {{$product->isInCart() ? 'in-cart' : ''}} "> {!!  $product->isInCart() ? '<span uk-icon="icon: check"></span>'.__('main.Added to cart') : '<span uk-icon="icon: cart"></span> '.__('main.Add to cart') !!} </button>
                            </div>
                            <div class="uk-margin-small">
                                <h5 class="uk-text-primary">{{__('main.This course includes')}}</h5>
                                <ul class="uk-list">
                                    <li><span uk-icon="icon: file-text"></span> 0 {{__('main.downloadable resources')}}</li>
                                    <li><span uk-icon="icon: unlock"></span> {{__('main.Full lifetime access')}}</li>
                                    <li><span uk-icon="icon: file-edit"></span> {{$product->lessons->where('type', \App\Modules\Course\Lesson::TYPE_QUIZ)->count()}} {{__('main.quizzes')}}</li>
                                    <li><span uk-icon="icon: bookmark"></span> {{__('main.Certificate of Completion')}}</li>
                                </ul>
                            </div>
                        </div>
                        <br>

                        @endif

                        {{--Groups--}}
                        <div class="uk-card uk-card-default uk-card-body" style="padding: 10px">
                            <ul uk-accordion="multiple: true">
                                @php
                                    $lessonCount = 0;
                                @endphp
                                @foreach($product->groups as $id => $group)
                                    <li class="{{$group->hasItem($lesson->id) ? 'uk-open' : ''}}" style="margin:0px 0px 10px 0px">
                                        <a class="uk-accordion-title text-highlighted uk-secondary-bg" style="padding: 10px 20px" href="#">{{sprintf('%02d', $id+1)}} | {{$group->title}}</a>
                                        <div class="uk-accordion-content">
                                            @foreach($group->items as $itemId => $item)
                                                @php
                                                    $lessonCount++;
                                                @endphp
                                                <a href="{{route('store.lesson.show', [$product->slug, $item->slug])}}">
                                                    <div class="uk-secondary-bg-hover">
                                                        <div style="padding: 5px">
                                                            <div class="uk-grid-small" uk-grid>
                                                                <div class="uk-width-auto@s uk-text-center uk-flex uk-flex-middle">
                                                                    @if($item->id == $lesson->id)
                                                                        <span class="uk-icon-box" style="height: 40px; width:40px; color: {{$product->getMainColorPattern()}}" uk-icon="icon: {{$lesson->type == \App\Modules\Course\Lesson::TYPE_PRESENTATION ? 'play-circle' : 'pencil'}}"></span>
                                                                    @else
                                                                        <span class="uk-icon-box" style="height: 40px; width:40px;">{{sprintf('%02d', $lessonCount)}}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="uk-width-expand@s uk-flex uk-flex-middle">
                                                                    <div class="{{$item->id == $lesson->id ? 'uk-text-primary' : ''}}">
                                                                        <p style="padding: 0px; margin: 0px">{{$item->title}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="uk-width-expand">
                        <div class="uk-grid-small uk-child-width-1-1@m" uk-grid="masonry: true">
                            @if($resources = $lesson->resources)
                                        @foreach($resources as $resource)
                                            <div>
                                                <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-remove" style="overflow: hidden">
                                                    @if($resource['type'] == \App\Modules\Media\Media::TYPE_VIDEO)
                                                        <video src="{{$resource['url']}}" loop muted playsinline controls disablepictureinpicture controlsList="nodownload"></video>
                                                    @elseif($resource['type'] == \App\Modules\Media\Media::TYPE_YOUTUBE || $resource['type'] == \App\Modules\Media\Media::TYPE_HTML_PAGE)
                                                        <iframe src="{{$resource['url']}}" class="uk-responsive-width" width="1920" height="1080" controls controlsList="nodownload" frameborder="0" uk-responsive></iframe>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                            <div>
                                        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small">
                                            <h5 class="text-highlighted uk-text-bold">{{__('main.Lesson quizzes')}}</h5>
                                            <table class="uk-table uk-table-divider uk-table-middle">
                                                <thead>
                                                <tr>
                                                    <th class="uk-width-1-3">{{__('main.Quiz name')}}</th>
                                                    <th class="uk-text-center">{{__('main.Items num.')}}</th>
                                                    <th class="uk-text-center">{{__('main.Quiz period')}}</th>
                                                    <td class="uk-text-center">{{__('main.Availability')}}</td>
                                                    <td class="uk-text-center">{{__('main.Results')}}</td>
                                                    <td></td>
                                                    <th class="uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($lesson->getAvailableForms() as $form)

                                                    <tr>
                                                        <td>
                                                            <p class="uk-margin-remove text-highlighted">{{$form->title}}</p>
                                                            <p class="uk-margin-remove">{!! $form->description !!}</p>
                                                        </td>
                                                        <td class="uk-text-center">{{$form->items->where('type', '!=', \App\Modules\Form\FormItem::TYPE_SECTION)->count()}}</td>
                                                        <td class="uk-text-center">
                                                            @if(!empty($form->properties['has_time_limit']) && $form->properties['has_time_limit'] == 1)
                                                                <span class="uk-text-warning">{{$form->properties['time_limit']}} {{trans_choice('main.Minutes', $form->properties['time_limit'])}}</span>
                                                            @else
                                                                <span class="uk-text-primary">{{__('main.Unlimited time')}}</span>
                                                            @endif
                                                        </td>
                                                        <td class="uk-text-center">
                                                            @if(!empty($form->getLastResponse()))
                                                                <p class="uk-text-{{$form->getLastResponse()->status == \App\Modules\Form\FormResponse::STATUS_FULLY_EVALUATED ? 'success' : 'warning'}}">{{__('main.'.$form->getLastResponse()->getStatus())}}</p>
                                                            @else
                                                                <p class="uk-text-primary">{{__('main.Available')}}</p>
                                                            @endif
                                                        </td>
                                                        <td class="uk-text-center">
                                                            @if(!empty($form->getLastResponse()) && $form->getLastResponse()->status == \App\Modules\Form\FormResponse::STATUS_FULLY_EVALUATED)
                                                                <p class="uk-margin-remove"><i class="far fa-check-circle uk-text-success"></i> {{$form->getLastResponse()->score_info['achieved_score']}} / {{$form->getLastResponse()->score_info['total_score']}}</p>
                                                                @if($form->getLastResponse()->status == \App\Modules\Form\FormResponse::STATUS_FULLY_EVALUATED)
                                                                    <a href="{{route('form.response.show', $form->getLastResponse()->hash_id)}}">{{__('main.View results')}}</a>
                                                                @endif
                                                            @else
                                                                <p class="uk-text-muted">{{__('main.No results')}}</p>
                                                            @endif
                                                        </td>
                                                        <td class="uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
                                                            <a class="uk-button uk-button-primary" href="{{route('store.form.show',[$lesson->slug, $form->hash_id])}}">{{__('main.Take the exam')}}</a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td>{{__('main.There is no form items yet.')}}</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>

                                        </div>
                            </div>
                            <div>
                                @if(false)
                                {{--attachments--}}
                                @if(!empty($attachments) && $attachments->count() > 0)

                                    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
                                        <h5 class="text-highlighted uk-text-bold">{{__('main.Attachments')}} (<span class="comment-count">{{$attachments->count()}}</span>)</h5>
                                        <table class="uk-table uk-table-divider">
                                            <thead>
                                            <tr>
                                                <th class="uk-table-shrink">{{__('main.File name')}}</th>
                                                <th class="uk-table-expand">{{__('main.File Type')}}</th>
                                                <th class="uk-width-small"> {{__('main.Download link')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($attachments as $attachment)
                                                <tr>
                                                    <td>{{$attachment->filename}}</td>
                                                    <td>{{$attachment->filetype}}</td>
                                                    <td><a target="_blank" class="uk-button uk-button-default uk-text-primary" href="{{$attachment->getTemporaryUrl(\Carbon\Carbon::parse(date('y-m-d'))->addDay())}}"><span uk-icon="icon: cloud-download"></span> <span>{{__('main.Download')}} </span></a></td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                                @endif
                                @if(false)
                                {{--comments--}}
                                <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
                                    <h5 class="text-highlighted uk-text-bold">{{__('main.Comments')}} (<span class="comment-count">{{$post->comments->where('status', 1)->count()}}</span>)</h5>
                                    <ul id="list-0" class="main-comments-list uk-comment-list comments-list-0">
                                        @if($post->allow_comments_status == 1)
                                            @if(isLoginIn())
                                                <li class="uk-fieldset main-comment-form">
                                                    <div class="uk-margin">
                                                        <textarea class="uk-textarea comment-text" rows="4" placeholder="{{__('main.Type your comment here ..')}}"></textarea>
                                                    </div>
                                                    <button class="uk-button uk-button-default add-comment">{{__('main.Comment')}}</button>
                                                </li>
                                            @else
                                                <div>
                                                    <div class="uk-card uk-card-body uk-text-center" style="border: 2px solid var(--theme-secondary-bg-color)">
                                                        <p>{{__('main.To add comments you are required to login with your account.')}}</p>
                                                        <a class="uk-button uk-button-primary" href="{{route('login')}}">{{__('main.Login now')}}</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        <li class="comment-loading-spinner">
                                            <div class="uk-margin">
                                                <div class="uk-text-center uk-text-primary">
                                                    <div>
                                                        <span uk-spinner="ratio: 2"></span>
                                                    </div>
                                                    <div class="uk-padding-small">
                                                        {{__('main.Loading')}} ...
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @if(false)
                                            <li>
                                                <article class="uk-comment bg-secondary uk-padding-small uk-visible-toggle" tabindex="-1">
                                                    <header class="uk-comment-header uk-position-relative">
                                                        <div class="uk-grid-medium" uk-grid>
                                                            <div class="uk-width-auto">
                                                                <img class="uk-comment-avatar uk-border-circle" src="https://getuikit.com/docs/images/avatar.jpg" width="80" height="80" alt="">
                                                            </div>
                                                            <div class="uk-width-expand">
                                                                <div class="uk-grid-medium" uk-grid>
                                                                    <div class="uk-width-expand">
                                                                        <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#">Author</a></h4>
                                                                        <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" href="#">12 days ago</a></p>
                                                                    </div>
                                                                    <div class="uk-width-auto">
                                                                        <ul class="uk-list comment-actions">
                                                                            <li><button class="uk-button uk-button-default uk-text-danger" style="padding: 0 10px"><span>1</span> <span class="fas fa-heart"></span></button></li>
                                                                            <li><button class="uk-button uk-button-default uk-text-primary">Replay</button></li>
                                                                            <li>
                                                                                <button class="uk-button uk-button-text" type="button" style="padding: 0 10px"><span uk-icon="icon:  more-vertical; ratio: 0.8"></span></button>
                                                                                <div uk-dropdown="pos: bottom-right">
                                                                                    <ul class="uk-list" style="padding: 0px; margin: 0px">
                                                                                        <li><a href="#">Report</a></li>
                                                                                        <li><a href="#">Edit</a></li>
                                                                                        <li><a href="#">Reply</a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="uk-comment-body">
                                                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </header>
                                                </article>
                                                <ul>
                                                </ul>
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                                @endif
                            </div>
                            <div>
                                <div class="uk-card uk-card-default uk-card-body uk-padding-small">
                                    <h5 class="text-highlighted uk-text-bold">{{__('main.Lesson description')}}</h5>
                                    {!! $lesson->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
    </div>
</section>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
</script>
@include('partial.scripts._cart')
@endsection
