<?php if ($articles->isEmpty()) { ?>
Not found articles
<?php } else { ?>
@foreach($articles as $art) 
<p>{{ $art->id }}</p>
<p>{{ $art->price }}</p>
<hr>
@endforeach
<?php } ?>
<hr><hr><hr>