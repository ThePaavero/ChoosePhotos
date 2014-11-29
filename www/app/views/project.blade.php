<h1>Project "{{ $data['title'] }}"</h1>

{{--{{ dd($data) }}--}}

<ul class='gallery'>
    @foreach($data['images'] as $image)
    <li>
        <div class='thumbnail-wrapper'>
            <img src='{{ $image['thumbnail'] }}' alt=''/>
        </div><!-- thumbnail-wrapper -->

        <a href='{{ $image['large'] }}' class='larger-link fancybox'>Larger</a>
    </li>
    @endforeach
</ul>
<!-- gallery -->