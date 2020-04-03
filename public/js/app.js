$( document ).ready(function() {
    $(".select-term").chosen();
    $(document).delegate('.select-term', "change", function() {
        $(this).attr('name', 'ter_id');
        var pid = $(this).val();
        var levelId = parseInt($(this).closest('select').attr('data-ter-level-id'));
        $.ajax({
            url: '/region/getTer',
            data: {
                ter_pid: pid,
            },
            success: function(result){
                var data = JSON.parse(result);
                if(typeof data.terArr !== 'undefined' && data.terArr.length >= 1) {
                    for( var i = levelId + 1; i <= 4; i++) {
                        $("#term-level-" + i).remove();
                        $("#term_level_"+i+"_chosen").remove();

                    }
                    levelId++;
                    var terLevelID = "term-level-" + levelId;
                    if ( $( "#"+terLevelID ).length ) {
                        var newSelect =  $( "#"+terLevelID );
                        console.log(newSelect);
                    } else {
                        var newSelect = $('<select class="select-term" id="'+terLevelID+'" data-ter-level-id="'+levelId+'" ></select>');
                    }
                    newSelect.html('');

                    newSelect.append('<option></option>');
                    for (index = 0; index < data.terArr.length; ++index) {
                        newSelect.append('<option value="'+data.terArr[index].ter_id+'">' + data.terArr[index].ter_name + '</option>');
                    }

                    $('#select-towm-block').append(newSelect);
                    $('#select-towm-block').append('<span style="color: red" id="error-ter-levelId-'+levelId+'"></span>');
                    $('#select-towm-block').find('#'+terLevelID).chosen();
                }
            }
        });
    });
    $('#main-form').on('submit', function(e) {
        return  validateOnsubmitReg($(this));
    });

});

function validateOnsubmitReg(form) {
    $('#email-error').text('');
    $('#fio-error').text('');
    $('#error-ter-levelId-1').text('');
    $('#error-ter-levelId-2').text('');
    var hasError = false;
    var fio = form.find('input[name="fio"]').val();
    var email = form.find('input[name="email"]').val();

   var obl =  $('select[data-ter-level-id=1]').val();
   if(!obl) {
       $('#error-ter-levelId-1').text('Выбирите область')
       hasError = true;
   }
    var town =  $('select[data-ter-level-id=2]').val();
    if(!town) {
        $('#error-ter-levelId-2').text('Выбирите горол');
        hasError = true;
    }
    if (!isEmail(email)) {
        $('#email-error').html('Email is invalid');
        hasError = true;
    }
    if(fio.length < 3) {
        $('#fio-error').html('Fio min length is 3');
        hasError = true;
    }
    return !hasError;
}
// function isEmail(email) {
//     var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//     return regex.test(email);
// }
function isEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}