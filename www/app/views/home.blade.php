
<h1>ChoosePhotos</h1>

<h2>Projects</h2>

{{--{{ dd($projects) }}--}}

<ul>
    @foreach($projects as $slug)
    <li>
        <a href='{{ URL::to('project/' . $slug) }}'>{{ $slug }}</a>
    </li>
    @endforeach
</ul>