<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel Task</title> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://demos.jquerymobile.com/1.4.2/css/themes/default/jquery.mobile-1.4.2.min.css">  
        <script src="https://demos.jquerymobile.com/1.4.2/js/jquery.js"></script> 
   	    <script src="https://demos.jquerymobile.com/1.4.2/js/jquery.mobile-1.4.2.min.js"></script>
	    <script>
	        $('input').popup();
	    </script>
	    <style>
	    form {
            margin: 100px 400px !important;
        }
        
        .ui-slider .ui-btn-inner {
            padding: 4px !important;
        }
 
        .ui-slider-popup {
            position: absolute !important;
            width: 32px;
            height: 32px;
            text-align: center;
            font-size: 16px;
            padding: 2px;
            z-index: 100;
            opacity: 0.8;
        }
	    </style>
    </head>
    <body>
        <div class="content">
        
            <div class="container mt-5">
                <form>
                    <div>
                        <label for="name">Search by name</label>
                        <input type="text" id="prName" name="name" placeholder="Enter name" />
                    </div> 
                    <div data-role="rangeslider">
                        <label for="from-price">Price:</label>
                        <input type="range" name="pricefrom" id="from_price" min="{{ $minPrice }}"; max="{{ $maxPrice }}"; value="{{ $minPriceDefault }}"; step="{{ $step }}"; data-popup-enabled="true" data-show-value="true">
                        <label for="to-price">Price:</label>
                        <input type="range" name="priceto" id="to_price" min="{{ $minPrice }}"; max="{{ $maxPrice }}"; value="{{ $maxPriceDefault }}"; step="{{ $step }}"; data-popup-enabled="true" data-show-value="true">
                    </div>
                    <div>
                        <input type="submit" value="submit" onclick="priceRange()" />
                    </div>
                </form>
            </div>
             
            <div class="container mt-5">  
                @if (count($articleFinds) == 0)
                    <p>Not found result</p>
                @else
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th width="20">Name</th>
                            <th width="30">Description</th>
                            <th width="5">Price</th>
                            <th width="35">Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articleFinds as $art)
                        <tr>    
                            <td>{{ $art->id }}</td>
                            <td>{{ $art->name }}</td>
                            <td>{{ $art->description }}</td>
                            <td>{{ $art->price }}</td>
                            <td><img src="{{ asset('storage/images/articles/'.$art->image) }}" class="img-thumbnail border-0" alt="article image" /></td>
                        </tr>  
                        @endforeach       
                    </tbody>
                </table>
                @endif
            </div>
            
        </div>    
    </body>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
   
</html>
