@extends('admin.master')
@section('content')
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Episode manager</h1>
        </div>
    </div><!--/.row-->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Update episode</div>
                <div class="panel-body">
                    <div class="col-lg-7">
                        @include('admin.component.alertForm')
                        <form class="form-horizontal" action="{!! route('episode.update', $episode['id']) !!}" method="post">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $episode['id'] }}">
                            <div class="form-group">
                                <label for="txtName" class="col-sm-3 control-label">Episode name</label>
                                <div class="col-sm-9">
                                    <input type="txt" class="form-control" id="txtName" name="txtName" value="{!! old('txtName', isset($episode) ? $episode['name'] : null) !!}" placeholder="Please enter episode name">
                                </div>
                            </div>
                            @foreach($links as $key => $link)
                            <div class="form-group">
                                <label for="txtLink" class="col-sm-3 control-label">Episode link {{$key}}</label>
                                <div class="col-sm-9">
                                    <input type="txt" value="{!! old('txtLink',$link['link']) !!}" class="form-control" id="txtLink" name="txtLink[]" placeholder="Please enter episode link">
                                </div>
                            </div>
                            @endforeach
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-default">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.row-->
</div>	<!--/.main-->
@endsection()