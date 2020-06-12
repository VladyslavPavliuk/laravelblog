@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                    <button class="bnt btn-primary">
                        <a class="bnt btn-primary" href="{{route('blog.admin.posts.create')}}">Write</a>
                    </button>
                </nav>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Publication date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $post)
                                @php /**@var \App\Models\BlogPost @post */ @endphp
                                <tr @if($post->is_pubblished) style="background-color: #ccc;" @endif>

                                    <td>{{$post->id}}</td>
                                    <td>{{$post->user->name}}</td>
                                    <td>{{$post->category->title}}</td>
                                    <td>
                                       <a href="{{route('blog.admin.posts.edit', $post->id)}}">{{$post->title}}</a>
                                    </td>
                                    <td>{{$post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d M H:i') : '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($paginator->total() > $paginator->count())
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{$paginator->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
