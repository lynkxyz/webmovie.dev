@extends('admin.master')
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    
    <div class="row">
        <div class="col-lg-12">
            <?php $movie_name = DB::table('movies')->select('name')->where('id', $id)->get() ?>
            <h1 class="page-header">Episode of {{ $movie_name[0]->name }}</h1>
            @include('admin.component.alert')
        </div>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="btn btn-success" href="{!! route('episode.create', $id) !!}">Create Episode</a>
                    <a type="button" class="btn btn-default" href="{!! route('movie.index') !!}">Close</a>
                </div>
                <div class="panel-body">
                    <h3>{{ $data->total() }} episodes</h3>
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Episode</th>
                            <th>Views</th>
                            <th>Likes</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php $stt = 0; ?>
                            @foreach($data as $item)
                                <?php $stt = $stt + 1; ?>
                                <tr>
                                    <th>{!! $stt !!}</th>
                                    <td>Episode {!! $item['name'] !!}</td>
                                    <td>{!! $item['views'] !!}</td>
                                    <td>{!! $item['likes'] !!}</td>
                                    <td>
                                        <a class="btn btn-default" href="{!! URL::route('episode.edit', $item['id']) !!}">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('episode.destroy', ['id'=>$item['id'], 'movieId' => $id]) }}" method="post" onsubmit='return confirmDelete()'>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                                            <button type="submit" class="btn btn-error" onlick="return false">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div>	<!--/.main-->
@endsection()