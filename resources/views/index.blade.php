<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel Task</title> 
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>       
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    </head>
    <body>
        <div class="content mt-5 mb-5"> <!-- content start -->
        
            {{-- SEARCH Article Start --}}
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <input type="search" name="name" id="name" class="form-control" placeholder="Enter Name" />
                    </div>
                    <div class="col-md-5">
                        <div id="slider-range"></div>
                        <p>
                            <label for="amount">Price:</label>
                            <input type="text" size="2" id="amount_start" class="m-1 border-0" name="start_price" value="" disabled />
                            <input type="text" size="2" id="amount_end" class="m-1 border-0" name="end_price" value="" disabled />
                        </p>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-primary" onclick="find()">Search</button>
                    </div>
                </div>
            </div>
            {{-- SEARCH Article END --}}
            
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
                                <p id="store_image"></p>
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
            
            {{-- FETCH Article Start --}}
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div id="success_message"></div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddArticleModal" class="btn btn-primary">Add Article</a>
                        <h4>Article Data</h4>
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Name</th>
                                    <th width="30%">Description</th>
                                    <th width="40%">Image</th>
                                    <th width="5%">Price</th>
                                    <th width="5%">Edit</th>
                                    <th width="5%">Delete</th>
                                </tr>
                            </thead>
                            <tbody class="allData">   
                            </tbody>
                            <tbody id="findData" class="findData">   
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div> 
            {{-- FETCH Article END --}}
            
        </div> <!-- content end -->
   
    <script src="/js/articles-crud-and-search.js"></script>
    </body>
</html>
