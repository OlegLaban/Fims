import './css/bootstrap-grid.css';
import './css/main.css';
import './scss/main.scss';
import $ from "jquery";


    $('#chisloOt, #chisloDo').on("change mousemove", function() {
        $(this).next().html($(this).val());
    });

    $('#logoCompanyOrWorker').on("change", function(){

        var $i = $('#logoCompanyOrWorker'), input = $i[0];
        if(input.files){
            var file = input.files, src, formData = new FormData();
            var src = $('#logoCompanyOrWorker').attr('data-src');
            if(file.length != 0) {
                console.log(file)
                for(var files in file){
                    formData.append(files, file[files]);
                }

            }
            var tr  = "/" + $('#logo').val();
            console.log(tr);
            $.ajax({
                url: tr,
                type: "POST",
                data: formData,
                dataType: "html",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#debug').html(data);
                    $('#logo').attr('value', data);
                    $('#imgFile').attr('src', data);
                }
            });




        }

    });

    /*$('#logoWorker').on("change", function(){

         var $i = $('#logoWorker'), input = $i[0];
         if(input.files){
             var file = input.files, src, formData = new FormData();
             var src = $('#logoWorker').attr('data-src');
             if(file.length != 0) {
                 console.log(file)
                 for(var files in file){
                     formData.append(files, file[files]);
                 }

             }
             var url = "/" + $("#logo").val() + "/";
             $.ajax({
                 url: "/site/AddImgW/",
                 type: "POST",
                 data: formData,
                 dataType: "html",
                 cache: false,
                 processData: false,
                 contentType: false,
                 success: function (data) {
                     $('#debug').html(data);
                     $('#logo').attr('value', data);
                     $('#imgFile').attr('src', data);
                 }
             });




         }

     });*/





