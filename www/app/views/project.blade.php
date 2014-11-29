<h1>Photoshoot "{{ $data['title'] }}"</h1>

{{--{{ dd($data) }}--}}

<ul class='gallery' data-projectSlug='{{ $data['slug'] }}'>
    @foreach($data['images'] as $image)
    <li>
        <div class='thumbnail-wrapper' data-accepted='{{ $image['accepted'] }}'>
            <img src='{{ $image['thumbnail'] }}' alt=''/>
        </div><!-- thumbnail-wrapper -->

        <a href='{{ $image['large'] }}' class='larger-link fancybox'>Larger</a>
        <a href='#accept' class='accept-link'>Accept</a>
        <a href='#reject' class='reject-link'>Reject</a>
    </li>
    @endforeach
</ul>
<!-- gallery -->