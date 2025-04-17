@extends("layouts.mystyle")
@section("content")

<div class="p-6">
    <h1 class="mb-6 text-3xl">{{$article->title}}</h1>
    <div>
            <p>{{$article->subtitle}}</p>
            <p>{{$article->article}}</p>
            @foreach ($article->comments as $comment)
            <p>
                @if (isset($comment->comment))
                {{ $comment->comment }}
                {{ $comment->id }}
                @else
                {{ $comment->predefinite_comment }}
                {{ $comment->id }}
                @endif
            </p>
            @endforeach
            <a href="{{ route('articles.edit', $article->id) }}">
                <button>Edit</button>
            </a>
            <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button>Delete</button>
    </form>
    </div>
    
    
</div>

@endsection