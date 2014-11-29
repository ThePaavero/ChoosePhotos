<h1>Photoshoot "{{ $data['title'] }}"</h1>

{{--{{ dd($data) }}--}}

<ul class='gallery'>
    @foreach($data['images'] as $image)
    <li>
        <div class='thumbnail-wrapper'>
            <img src='{{ $image['thumbnail'] }}' alt=''/>
        </div><!-- thumbnail-wrapper -->

        <a href='{{ $image['large'] }}' class='larger-link fancybox'>Larger</a>
        <a href='#accept' class='accept-link'>Accept</a>
        <a href='#reject' class='reject-link'>Reject</a>
    </li>
    @endforeach
</ul>
<!-- gallery -->