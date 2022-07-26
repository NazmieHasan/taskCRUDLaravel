<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel Task</title> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>
    
    <body>
        <div class="content">
            <div class="modal fade" id="AddArticleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul id="saveform_errList"></ul>
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" class="name form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Description</label>
                                <input type="description" class="description form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Image</label>
                                <input type="text" class="image form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Price</label>
                                <input type="text" class="price form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary add_article">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div id="success_message"></div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddArticleModal" class="btn btn-primary">Add Article</a>
                        <h4>Article Data</h4>
                    </div>
                </div>  
            </div> 
        </div>    
    </body>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    <script>
        $(document).ready(function () {
            $(document).on('click', '.add_article', function (e) {
                e.preventDefault();
                
                var data = {
                    'name': $('.name').val(),
                    'description': $('.description').val(),
                    'image': $('.image').val(),
                    'price': $('.price').val(),
                }
                console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    type: "POST",
                    url: "/articles",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 400) {
                            $('#saveform_errList').html("");
                            $('#saveform_errList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_values) {
                                $('#saveform_errList').append('<li>'+err_values+'</li>');    
                            });
                        } else {
                            $('#saveform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddArticleModal').modal('hide');
                            $('#AddArticleModal').find('input').val("");
                        }
                        
                    }
                });
                    
               
            });
        });
    
    </script>
</html>
