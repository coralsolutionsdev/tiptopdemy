<section class="section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-spacing">
				<div class="card border-light">
					<div class="card-body">
						<h5>{{__('comments')}}</h5>
						<div class="row">
							<div class="col-md-12 comment-box">
								@foreach($post->comments as $comment_item)
									<div class="media comment">
										{{--<img src="http://coral.local/uploads/profile/avatars/male.png" class="rounded-circle avatar">--}}
										<img class="mr-3 rounded-circle avatar" src="http://coral.local/uploads/profile/avatars/male.png" alt="Generic placeholder image">
										<div class="media-body">
											<p class="mt-0 comment_user text-primary">{{$comment_item->user->name}}</p>
											<p class="comment-template-text">{{$comment_item->content}}</p>
										</div>
										@if($comment_item->user_id == Auth()->user()->id)
											<div class="pull-right align-self-end">
												<span id="{{$comment_item->id}}" class="fa fa-trash-o remove-comment" aria-hidden="true"></span>
											</div>
										@endif
									</div>
								@endforeach

								<div class="media comment comment-template hidden">
									{{--<img src="http://coral.local/uploads/profile/avatars/male.png" class="rounded-circle avatar">--}}
									<img class="mr-3 rounded-circle avatar" src="http://coral.local/uploads/profile/avatars/male.png" alt="Generic placeholder image">
									<div class="media-body">
										<p class="mt-0 comment_user text-primary"></p>
										<p class="comment-template-text"></p>
									</div>
									<div class="pull-right align-self-end">
										<span id="" class="fa fa-trash-o remove-comment" aria-hidden="true"></span>
									</div>
								</div>

							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<textarea name="comment" id="" cols="30" rows="3" class="form-control comment-field" placeholder="Leave your comment.."></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<span class="btn btn-primary pull-right add-comment">Submit</span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
