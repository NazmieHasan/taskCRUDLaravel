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
        
            <div class="modal fade" id="AddArticleModal" tabindex="-1" aria-labelledby="AddModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                            <form action="{{ url('store-articles') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                        @if($errors->has('name'))
                                            <div class="error">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea class="form-control" rows="6" name="description"></textarea>
                                        @if($errors->has('description'))
                                            <div class="error">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Image</label>
                                        <input accept=".jpg, .jpeg" type="file" name="image" class="form-control">
                                        @if($errors->has('image'))
                                            <div class="error">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control" placeholder="Enter Price">
                                        @if($errors->has('price'))
                                            <div class="error">{{ $errors->first('price') }}</div>
                                        @endif
                                    </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary add_article">Save</button>
                        </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="container mt-5">
                <a href="#" data-bs-toggle="modal" data-bs-target="#AddArticleModal" class="btn btn-primary">Add Article</a>
                <br /><br /><br />
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
               @endif
            </div>
        
        </div>    
    </body>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
