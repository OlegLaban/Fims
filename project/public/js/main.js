window.onload = function () {

   $('#chisloOt, #chisloDo').on("change mousemove", function() {
        $(this).next().html($(this).val());
   });

   $('#logoCompany').on("change", function(){

       var $i = $('#logoCompany'), input = $i[0];
       if(input.files){
           var file = input.files, src, formData = new FormData();
           var src = $('#logoCompany').attr('data-src');
           if(file.length != 0) {
               console.log(file)
                for(var files in file){
                    formData.append(files, file[files]);
                }

           }
          $.ajax({
               url: "/site/addImg/",
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

    $('#logoWorker').on("change", function(){

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
            $.ajax({
                url: "/site/addImgW/",
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
}