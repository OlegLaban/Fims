import './css/bootstrap-grid.css';
import './css/main.css';
import './scss/main.scss';
import jQuery from "jquery";
window.$ = window.jQuery = jQuery;


window.onload = function (){
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

    $("#resetData").on('click', function(){
        var childrenForm = [], arrElements = ['input:not(.button)', 'select'];
        for(var i = 0; i < arrElements.length; i++){
            childrenForm[i] = $("#formEditUser").children(arrElements[i]);
        }
        console.log(childrenForm.length);
        console.log(childrenForm);
        for (var q = 0; q <= childrenForm.length; q++){

            console.log("q = " + q);
            for (var j = 0; j < childrenForm[q].length; j++){
                if(childrenForm[j].prop("localName") === 'select'){
                    $(childrenForm[j].children()[0]).attr('selected', 'select');
                    continue;
                }
                childrenForm[j].val("");
            }
        }
    });


}






