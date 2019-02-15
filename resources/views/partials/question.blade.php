<article class="question single-question question-type-normal">
    
    {!!   $routeIsQuestionShow ? '':'<a href="'.url('/questions/'.$question->id).'">' !!}
        <h2>
            <span class="color" style="width : 88%;">{{ $question->title }}</span>
            @if(Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->fabric_id == $question->user->fabric_id)
            <form method="POST" action="{{route('questionEdit')}}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$question->id}}" name="questionId">
                <button type="submit" class="button question-report delete-button ">Editer</button>
            </form>
            @endif

            @if(Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->fabric_id == $question->user->fabric_id)
            <form method="POST" action="{{route('questionLock')}}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$question->id}}" name="questionId">
                <button type="submit" onclick="return confirm('Confirmer la fermeture ?')" class="button question-report delete-button ">Supprimer</button>
            </form>
            @endif
        </h2>
    {!!  $routeIsQuestionShow ? '':'</a>' !!}

    <div class="question-author-date">
        <em>{{ $question->created_at->diffForHumans() }}</em> par <span class="color">{{ $question->user->name }}</span> | <span>{{ $question->user->fabric->name }}</span>
    </div>
    <div class="question-inner">
        <div class="clearfix"></div>
        <div class="comment-vote">
            <ul class="question-vote">

                @if(in_array($question->id, $userQuestionPreviousVotes))
                    <li>
                        <input type="submit" value="▲"
                               class="question-vote-up tooltip-n"
                               title='Vous avez déjà upvoté cette question'>
                    </li>
                @else
                    <li>
                        {!! Form::open(['action' => 'UpvoteController@store', 'method' => 'post']) !!}
                        {!! Form::hidden('question_id', $question->id) !!}
                        {!! Form::submit('▲', ['class' => 'question-vote-up']) !!}
                        {!! Form::close() !!}
                    </li>
                @endif
                <!--<li><a href="#" class="question-vote-down" title="Dislike"></a></li>!-->
            </ul>

            <div class="question-vote-result">
                {{count($question->upvotes)}}
            </div>
        </div>
        <div class="question-desc">
            {!! strip_tags($question->description, '<a><b><blockquote><code><del><dd><dl><dt><em><h1><h2><h3><i><kbd><li><ol><p><pre><s><sup><sub><strong><strike><ul><br><hr>') !!}
        </div>
        <!--<div class="question-details">
            <span class="question-answered question-answered-done"><i class="icon-ok"></i>Résolu</span>
        </div>
        -->
        <span class="question-comment"><a href="/questions/{{$question->id}}#commentlist"><i class="icon-comment"></i>{{ count($question->answers) }} Réponse(s)</a></span>
        <span class="question-view">👁 {{ $question->views }} vues  </span>
        @if($question->hasSelectedAnswer)
            <span class="question-answered">✔️ Solution trouvée</span>
        @endif
        <span class="label ">{{$question->user->fabric->name}}</span>
        <div class="question-tags"><i class="icon-tags"></i>
            <a href="#!">{{ $question->category }}</a>
        </div>
        <div class="clearfix"></div>
    </div>
</article>