@extends('home.master')
@section('content')
<div id="newEpisodes" class="main__citem animated fadeInDown">
  <div class="row main__header">
    <div class="col-md-9 col-sm-7 col-xs-5">
      <h3>All Genre</h3>
    </div>
  </div>

  <div class="row main__citem-content">
    @foreach($genres as $genre)
    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6" >
      <div class="main__citem-item">
        <a href="{!! route('genrepage.show', $genre['id']) !!}">
          <div class="main__citem-des">
            <h2>{{ $genre['name'] }}</h2>
          </div>
        </a>
        
      </div>
    </div>
    @endforeach
  </div>
</div>

<script>
  window.document.title = "Webmovie - Trang xem anime online";
</script>
@endsection()