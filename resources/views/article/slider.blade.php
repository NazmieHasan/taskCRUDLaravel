<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Slider - Range slider</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>       
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 500,
      max: 1400,
      values: [ 800, 1000 ],
      slide: function( event, ui ) {
        $("#amount_start").val(ui.values[0]);
        $("#amount_end").val(ui.values[1]);
        
        var start = $("#amount_start").val();
        var end = $("#amount_start").val();
        
        $.ajax({
            method: 'get', 
            dataType: 'html',
            url: '/slider', 
            data: "start="+start+"&end="+end,
            
            success: function (response) {
                console.log(response);
                $('#updateDiv').html(response);
            }
            
        });  
        
        
        
      }
    });
    
  });
  </script>
</head>
<body>

<div class="container mt-5">
 
<p>
  <label for="amount">Price range:</label>
  <input type="text" size="3" id="amount_start" name="start_price" value="800">
  <input type="text" size="3" id="amount_end" name="end_price" value="1000">
</p> 
<div id="slider-range"></div>

<div id='updateDiv'></div>

<?php if ($articles->isEmpty()) { ?>
Not found articles
<?php } else { ?>
@foreach($articles as $art) 
<p>{{ $art->id }}</p>
<p>{{ $art->price }}</p>
<hr>
@endforeach
<?php } ?>

</div>



</body>
</html>