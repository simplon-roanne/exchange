
<div class="card mt-3 shadow-sm">
    <div class="card-body">
        @if(Request::is('questions/user'))
            @if(isset($subscriberReply[$question->id]))
                <form action="{{ route('profil.editNotification') }}" method="post" class="mb-3 notificationQuestionUser" id="registerForm">
                    {{ csrf_field() }}
                    <div class="form-control py-2 col-6">
                        <div class="custom-control custom-checkbox">
                            <input autocomplete="off" class="custom-control-input " type="checkbox" name="token_firebase" value="" id="disableCheckboxNotification">
                            <label class="custom-control-label " for="disableCheckboxNotification">Ne plus recevoir des notifications pour cette question ?</label>
                        </div>
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <button type="submit" class="btn colorBackgroundSimplon btn-notif">Envoyer</button>
                    </div>

                </form>
            @endif

            @if(!isset($subscriberReply[$question->id]))
                <form action="" class="mb-3">
                    {{ csrf_field() }}
                    <div class="form-control py-2 col-6">
                        <div class="custom-control custom-checkbox">
                            <input autocomplete="off" class="custom-control-input " type="checkbox"  onclick="enableNotifications({type:'question'})" id="checkboxNotification">
                            <label class="custom-control-label " for="checkboxNotification">Voulez-vous recevoir des notifications pour cette question ?</label>
                        </div>
                        <button type="submit" class="btn colorBackgroundSimplon btn-notif">Envoyer</button>
                    </div>
                </form>
            @endif
        @endif
        <a class="card-link title-card colorTextSimplon" href="{{ url('/questions/'.$question->id) }}">{{ $question->title }}</a>

        <div class="btn-block-admin">
            @if(Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->fabric_id == $question->user->fabric_id)
                <form method="POST" action="{{ route('questionEdit') }}" class="btn-admin ">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$question->id}}" name="questionId">
                    <button class="btn" type="submit" data-toggle="tooltip" data-placement="top" title="Editer"><i class="fas fa-edit"></i></button>
                </form>
            @endif

            @if(Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->fabric_id == $question->user->fabric_id)
                <form method="POST" action="{{ route('deleteQuestion') }}" class="btn-admin mx-2">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$question->id}}" name="questionId">
                    <button class="btn" type="submit" data-toggle="tooltip" data-placement="top" title="Supprimer"
                            onclick="return confirm('Confirmer la suppression ?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @endif

            @if (Auth::check() && Auth::user()->is_admin == 1 && !$question->is_locked )
                    <form method="post" action="{{ route('questionLock') }}" class="btn-admin">
                        {{ csrf_field() }}
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <button type="submit" id="submit" class="btn" data-toggle="tooltip" data-placement="top" title="Fermer la question"
                                onclick="return confirm('Confirmer la fermeture de la question ?')">
                                <i class="fas fa-lock"></i>
                        </button>
                    </form>
                <hr>
            @endif
        </div>

        <div class="mb-2 mt-2 clearfix">
            <em class="text-muted">{{ $question->created_at->diffForHumans() }} par </em><b>{{ $question->user->name }}</b>, <span class="text-muted mt-0 mb-1">Karma : {{ $question->user->points }}</span>

        </div>

        <hr>

        <div class="d-inline-flex flex-column align-middle">
            @if(in_array($question->id, $userQuestionPreviousVotes))
                <li class="list-unstyled mb-1">
                    <input type="submit" value="▲"
                        class="upVoted"
                        title='Vous avez déjà upvoté cette question'>
                </li>
            @else
                <li class="list-unstyled mb-1">
                    {!! Form::open(['action' => 'UpvoteController@store', 'method' => 'post']) !!}
                    {!! Form::hidden('question_id', $question->id) !!}
                    {!! Form::submit('▲', ['class' => 'question-vote-up']) !!}
                    {!! Form::close() !!}
                </li>
            @endif

            <div class="text-center nbVotes">
                {{count($question->upvotes)}}
            </div>
        </div>
        <div class="card-text d-inline-block col-11 align-middle mt-2">
            {!! strip_tags($question->description, '<a><b><blockquote><code><del><dd><dl><dt><em><h1><h2><h3><i><kbd><li><ol><p><pre><s><sup><sub><strong><strike><ul><br><hr>') !!}
        </div>
        <hr>
        <div class="clearfix link-card">
                <a href="/questions/{{$question->id}}" class="card-link "><i class="fas fa-comment"></i> {{ count($question->answers) }} Réponse(s)</a>
                <span class="ml-3"><i class="far fa-eye"></i> {{ $question->views }} vues </span>
                @if($question->hasSelectedAnswer)
                    <span class="ml-3"><i class="fas fa-check"></i> Solution trouvée</span>
                @endif
                <span class="ml-3 colorBackgroundSimplon fabric-span">{{ $question->user->fabric->name }}</span>

                <a href="/?category={{ $question->category }}" class="float-right card-link ml-3"><i class="fas fa-tags"></i> {{ $question->category }}</a>
                <div class="clearfix"></div>
        </div>
    </div>
</div>
