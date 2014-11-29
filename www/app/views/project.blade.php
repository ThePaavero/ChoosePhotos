<h1>Project "{{ $data['title'] }}"</h1>

{{--{{ dd($data) }}--}}

<ul>
    @foreach($data['images'] as $image)
    <li>
        <a href='{{ $image['large'] }}'>
            <img src='{{ $image['thumbnail'] }}' alt=''/>
        </a>
    </li>
    @endforeach
</ul>
