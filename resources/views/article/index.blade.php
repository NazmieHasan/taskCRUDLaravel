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
        
            {{-- Add Article Modal Start --}}
            <div class="modal fade" id="AddArticleModal" tabindex="-1" aria-labelledby="AddModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                         <form id="formAddArticle" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <ul id="saveform_errList"></ul>
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="name form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Description</label>
                                <textarea class="description form-control" rows="6" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Image</label>
                                <input accept=".jpg, .jpeg" type="file" class="image form-control" name="image">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Price</label>
                                <input type="text" class="price form-control" name="price" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary add_article">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Add Article Modal End --}}
            
            {{-- Edit Article Modal Start --}}
            <div class="modal fade" id="EditArticleModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit & Update Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                         <form id="formEditArticle" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <ul id="updateform_errList"></ul>
                            <input type="hidden" id="edit_art_id" />
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" id="edit_name" class="form-control" name="name" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Description</label>
                                <textarea class="form-control" id="edit_description" rows="6" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Image</label>
                                <input accept=".jpg, .jpeg" type="file" id="edit_image" class="image form-control" name="image">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Price</label>
                                <input type="text" id="edit_price" class="form-control" name="price" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary update_article">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Edit Article Modal End --}}
            
            {{-- Delete Article Modal Start --}}
            <div class="modal fade" id="DeleteArticleModal" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="delete_art_id" />
                            <h4>Are you sure want to delete this data?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger delete_article_btn">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Delete Article Modal End --}}
            
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div id="success_message"></div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddArticleModal" class="btn btn-primary">Add Article</a>
                        <h4>Article Data</h4>
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>   
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div> 
            
        </div>    
    </body>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
    <script>
        $(document).ready(function () {
        
            fetchArticle();
       
            function fetchArticle() {
                $.ajax({
                    method: "GET",
                    url: "/fetch-articles",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.articles, function (key, item) {
                            $('tbody').append('<tr>\
                                <td>'+item.id+'</td>\
                                <td>'+item.name+'</td>\
                                <td>'+item.description+'</td>\
                                <td><img src="{{ asset('storage/images/articles')}}/'+item.image+'" class="img-thumbnail border-0" alt="article image" ></td>\
                                <td>'+item.price+'$</td>\
                                <td><button type="button" value="'+item.id+'" class="edit_article btn btn-primary btn-sm">Edit</button</td>\
                                <td><button type="button" value="'+item.id+'" class="delete_article btn btn-danger btn-sm">Delete</button</td>\
                            </tr>'); 
                        });     
                    }
                });  
            }
            
            $(document).on('click', '.delete_article', function (e) {
                e.preventDefault();
                var art_id = $(this).val();
                $('#delete_art_id').val(art_id);
                $('#DeleteArticleModal').modal('show');
            });
            
            $(document).on('click', '.delete_article_btn', function (e) {
                e.preventDefault();
                
                $(this).text("Deleting");
                var art_id = $('#delete_art_id').val();
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    method: "POST",
                    url: "/delete-article/"+art_id,
                    success: function (response) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#DeleteArticleModal').modal('hide');
                        $('.delete_article_btn').text("Yes, Delete");
                        fetchArticle();
                    }
                });
                
            });
            
            
            $(document).on('click', '.edit_article', function (e) {
                e.preventDefault();
                var art_id = $(this).val();
                $('#EditArticleModal').modal('show');
                $.ajax({
                    method: "GET",
                    url: "/edit-article/"+art_id,
                    success: function (response) {
                        if(response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#edit_name').val(response.article.name);
                            $('#edit_description').val(response.article.description);
                            $('#edit_price').val(response.article.price);
                            $('#edit_art_id').val(art_id);
                        }
                    }
                });
            });
            
            $(document).on('click', '.update_article', function (e) {
                e.preventDefault();
                
                $(this).text("Updating");
                
                var art_id = $('#edit_art_id').val();
                
                var name = $('#edit_name').val();
                var description = $('#edit_description').val();
                var fileName = $('#edit_image').val();
                var price = $('#edit_price').val();
                
                var totalFormData = new FormData($("#formEditArticle")[0]);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    method: "POST",
                    url: "/update-article/"+art_id,
                    data: totalFormData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 400) {
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_values) {
                                $('#updateform_errList').append('<li style="list-style: none;">'+err_values+'</li>');    
                            });
                            $('update_article').text('Update');
                        } else if(response.status == 404) {
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('update_article').text('Update');
                        } else {
                            $('#updateform_errList').html("");
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            
                            $('#EditArticleModal').modal('hide');
                            $('update_article').text('Update');
                            fetchArticle();
                        }
                    }
                });
              
            });
        
        
            $(document).on('click', '.add_article', function (e) {
                e.preventDefault();
                
                var name = $('.name').val();
                var description = $('.description').val();
                var fileName = $('.image').val();
                var price = $('.price').val();
                
                var totalFormData = new FormData($("#formAddArticle")[0]);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    method: "POST",
                    url: "/articles",
                    data: totalFormData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 400) {
                            $('#saveform_errList').html("");
                            $('#saveform_errList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_values) {
                                $('#saveform_errList').append('<li style="list-style: none;">'+err_values+'</li>');    
                            });
                        } else {
                            $('#saveform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddArticleModal').modal('hide');
                            $('#AddArticleModal').find('input').val("");
                            fetchArticle();
                        }
                        
                    }
                });
                    
               
            });
        });
    
    </script>
</html>
