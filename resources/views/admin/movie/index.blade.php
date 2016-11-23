@extends('admin.master')
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Icons</li>
        </ol>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Movies manager</h1>
            @include('admin.component.alert')
        </div>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="btn btn-success" href="{!! route('movie.create') !!}">Create Movie</a>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Movie</th>
                            <th>Status</th>
                            <th>Thumb</th>
                            <th>Views</th>
                            <th>Total Episodes</th>
                            <th>Year</th>
                            <th>Season</th>
                            <th>Producer</th>
                            <th>Edit</th>
                            <th>View</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php $stt = 0; ?>
                            @foreach($data as $item)
                                <?php $stt = $stt + 1; ?>
                                <tr>
                                    <th>{!! $stt !!}</th>
                                    <td>{!! $item['name'] !!}</td>
                                    <td>{!! $item['status'] !!}</td>
                                    <td>
                                        <img src="{!! $item['thumb'] !!}" alt="{!! $item['name'] !!}">
                                    </td>
                                    <td>{!! $item['views'] !!}</td>
                                    <td>{!! $item['total_episodes'] !!}</td>
                                    <td>
                                        <?php
                                        $year = DB::table('years')->where('id', $item['year'])->first();
                                        echo $year->name
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $season = DB::table('seasons')->where('id', $item['season'])->first();
                                        echo $season->name
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $producer = DB::table('producers')->where('id', $item['producer'])->first();
                                        echo $producer->name
                                        ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-default" href="{!! URL::route('movie.edit', $item['id']) !!}">Edit</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-default" href="{!! URL::route('movie.show', $item['id']) !!}">View</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('movie.destroy', $item['id']) }}" method="post">
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
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div>	<!--/.main-->
@endsection()