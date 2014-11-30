<h1>Photoshoot "{{ $data['title'] }}"</h1>

{{--{{ dd($data) }}--}}

<ul class='gallery' data-projectSlug='{{ $data['slug'] }}'>
    @foreach($data['images'] as $image)
    <li>
        <div class='thumbnail-wrapper {{ $image['accepted'] === 'yes' ? 'accepted' : '' }}' data-accepted='{{ $image['accepted'] }}'>
            <img src='{{ $image['thumbnail'] }}' alt=''/>
        </div><!-- thumbnail-wrapper -->

        <a href='{{ $image['large'] }}' class='larger-link fancybox'>Larger</a>
        <a href='#accept' class='accept-link'>Accept</a>
        <a href='#reject' class='reject-link'>Reject</a>
    </li>
    @endforeach
</ul>
<!-- gallery -->

<div class='client-tools-wrapper wrapper clear'>
    <nav>
    	<ul>
    		<li>
    		    <button href='{{ URL::to('notify-of-update/' . $data['slug']) }}' class='send-email-link'>Send en email about status updates</button>
    		</li>
    	</ul>
    </nav>
</div>
<!-- client-tools-wrapper wrapper -->