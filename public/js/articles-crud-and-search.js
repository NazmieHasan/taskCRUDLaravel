    // set values in range slider
    $("#slider-range").slider({
        range: true,
        min: 1,
        max: 10,
        values: [5, 7],
        step: 3,
        slide: function( event, ui ) {
            $("#amount_start").val(ui.values[0]);
            $("#amount_end").val(ui.values[1]); 
        }
    });
    
    // find articles by name, min price and max price
    function find() {
        var startPr = $("#amount_start").val();
        var endPr = $("#amount_end").val();
        var name = $("#name").val();
                
        if ((name) || (startPr) || (endPr)) {
            $('.allData').hide();
            $('.findData').show();
        } else {
            $('.allData').show();
            $('.findData').hide();
        }
                
        $.ajax({
            method: 'get', 
            url: '/search', 
            data: "name="+name+"&startPrice="+startPr+"&endPrice="+endPr,
            
            success: function (data) {
                $('#findData').html(data);
            }
        });  
    }
            
    $(document).ready(function () {

        // add article
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
                url: "/create-article",
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
                        customValuesSlider();
                        fetchArticle();
                    }         
                }
            });
                             
        });
    
        // edit article
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
                        $('#store_image').html("<img src=/images/articles/" + response.article.image + " width='80' class='img-thumbnail mt-1 border-0' alt='article image' />");
                        $('#store_image').append("<input type='hidden' name='hidden_image' value='"+response.article.image+"' />");
                        $('#edit_price').val(response.article.price);
                        $('#edit_art_id').val(art_id);
                    }
                }
            });
        });
         
        //update article   
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
                        $('#updateform_errList').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                        $('update_article').text('Update');
                    } else {
                        $('#updateform_errList').html("");
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#EditArticleModal').modal('hide');
                        $('update_article').text('Update');
                        customValuesSlider();
                        fetchArticle();
                    }
                }
            });
              
        });
         
        //delete article   
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
                    customValuesSlider();
                    fetchArticle();
                }
            });
                
        });
          
          
        customValuesSlider()
         
        // set values in range slider from database  
        function customValuesSlider() {
            var min, max, step, minDefault, maxDefault;
            
            $.ajax({
                url: "/custom-values-slider",
                dataType: "json",
                async: false,
                success: function(response) {
                    max = response.max;
                    min = response.min;
                    minDefault = response.minDefault;
                    maxDefault = response.maxDefault;
                    step = response.step;
                }
            });
 
            $( "#slider-range" ).slider({
                min: Number(min),
                max: Number(max),
                values: [minDefault, maxDefault],
                step: Number(step),
            });

            $("#amount_start").val(minDefault);   
            $("#amount_end").val(maxDefault);
        
        }
        
        $('.findData').hide();       
               
        fetchArticle();
       
        // fetch article
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
                            <td><img src="/images/articles/'+item.image+'" class="img-thumbnail border-0" alt="article image" /></td>\
                            <td>'+item.price+'$</td>\
                            <td><button type="button" value="'+item.id+'" class="edit_article btn btn-primary btn-sm">Edit</button</td>\
                            <td><button type="button" value="'+item.id+'" class="delete_article btn btn-danger btn-sm">Delete</button</td>\
                        </tr>'); 
                    });     
                }
            });  
        }
                       
    });
    