<h1>Project "{{ $data['title'] }}"</h1>

{{--{{ dd($data) }}--}}

<ul>
    @foreach($data['images'] as $image)
    <li>
        <a href='#'>
            <img src='{{ $image['fullUrl'] }}' alt=''/>
        </a>
    </li>
    @endforeach
</ul>
