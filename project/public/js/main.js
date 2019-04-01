window.onload = function () {

   $('#chisloOt, #chisloDo').on("change mousemove", function() {
        $(this).next().html($(this).val());
   });
}