
// Display Payment Schedule
$(".p-method input").on('change', function(){
    var week_flag = false;
    $('.sch input').each(function(){
        week_flag = $(this).val() == 1 && $(this).prop('checked') == true ? true : false;
    })
    if(week_flag == true){
        if($(".num_weeks").val() < 4){
            $(".sch input").each(function(){
                $(this).val() == 0 ? $(this).click() : ''
            })
        }
        else{
            $(".sch input").each(function(){
                $(this).val() == 2 ? $(this).click() : ''
            })
        }
    }
    if($(this).val() == 1){
        $('.sch').find('input').each(function(){
            if($(this).val() == 1){
                $(this).parent().css('display', 'none');
            }
        })
    }
    else{
        $('.sch').find('input').each(function(){
            if($(this).val() == 1){
                $(this).parent().css('display', 'inline-block');
            }
        })
    }
})
function change_sch(){
    var weeks = $(".num_weeks").val();
    if(weeks <= 4){
        $('.sch').find('input').each(function(){
            if($(this).val() == 0 || $(this).val() == 1){
                $(this).prop('checked', true);
            }
            else{
                $(this).parent().css('display', 'none');
            }
        })
    }
    else if(weeks > 4 && weeks < 12){
        $('.sch').find('input').each(function(){
            if($(this).val() == 2){
                $(this).prop('checked', true);
            }
            // Check Available Credit
            $(this).parent().css('display', 'inline-block');
            if($(this).val() == 3){
                $(this).parent().css('display', 'none');
            }
            if($.inArray("2", p_meth) === -1){
                if($(this).val() == 1){
                    $(this).parent().css('display', 'none');
                }
            }
        })
    }
    else{
        $('.sch').find('input').each(function(){
            if($(this).val() == 2){
                $(this).prop('checked', true);
            }
            // Check Available Credit
            $(this).parent().css('display', 'inline-block');
            if($.inArray("2", p_meth) === -1){
                if($(this).val() == 1){
                    $(this).parent().css('display', 'none');
                }
            }
        })
    }
}