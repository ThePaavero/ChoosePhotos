
<h1>ChoosePhotos</h1>

<h2>Projects</h2>

{{--{{ dd($projects) }}--}}

<ul class='admin-list-of-projects'>
    @foreach($projects as $slug)
    <li>
        <a href='{{ URL::to('project/' . $slug) }}'>{{ ucfirst($slug) }}</a>
    </li>
    @endforeach
</ul><!-- admin-list-of-projects -->