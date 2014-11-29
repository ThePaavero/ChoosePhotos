<h1>Project "{{ $data['title'] }}"</h1>

{{--{{ dd($data) }}--}}

<ul class='gallery'>
    @foreach($data['images'] as $image)
    <li>
        <a href='{{ $image['large'] }}' class='fancybox'>
            <img src='{{ $image['thumbnail'] }}' alt=''/>
        </a>
    </li>
    @endforeach
</ul>
<!-- gallery -->