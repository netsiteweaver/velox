jQuery(function(){

    $('.input-group-text.clear-search').on("click",function(){
        let elem = $(this).siblings("input").val();
        if(elem=="") return false;
        $(this).siblings("input").val("");
    })

    $('input[name=gender]').on("change",function(){
        let gender = $(this).val();
        if(gender=='m'){
            $("input[name=title][value='Mr']").prop("disabled",false);
            $("input[name=title][value='Mrs']").prop("disabled",true);
            $("input[name=title][value='Miss']").prop("disabled",true);
            $("input[name=title][value='Dr']").prop("disabled",false);
            $('input:radio[name=title]')[0].checked = true;
        }else{
            $("input[name=title][value='Mr']").prop("disabled",true);
            $("input[name=title][value='Mrs']").prop("disabled",false);
            $("input[name=title][value='Miss']").prop("disabled",false);
            $("input[name=title][value='Dr']").prop("disabled",false);
            $('input:radio[name=title]')[1].checked = true;
        }
    })

    $('#edit-code').on("click",function(){
        if($('#customer_code').attr("readonly")=="readonly") {
            $('#customer_code').removeAttr("readonly")
        }else{
            $('#customer_code').attr("readonly","readonly")
        }
        
    })

    $('.select-district').on("click",function(e){
        e.preventDefault();
        let district = $(this).attr("title");
        alert(district);
    })
})