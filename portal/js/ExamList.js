$(document).ready(function(e) {
    // Submit form data via Ajax
    $("button").on('click', function(e) {
        e.preventDefault();

        let examId = e.target.id.substr(1);
        let matric = $("#form" + examId).serializeArray()[1].value;

        $('#s' + examId).addClass("spinner-border").addClass("spinner-border-sm");
        $('#b' + examId).prop('disabled', true);

        // //check exam availability
        $.ajax({
            type: 'POST',
            url: 'https://bucbt.bowen.edu.ng/college-exam/api/check_exam_availability.php',
            data: { matric: matric, examId: examId },
            success: function(resp) {
                if (resp.data) {
                    $('#form' + examId).submit();
                } else {
                    alert(resp.message)
                }
            },
            fail: function(xhr, textStatus, errorThrown) {
                alert("Network Error, please retry!");
            },
            error: function(e, f, g) {
                console.log(e);
                alert("Network Error, please ensure you have stable internet connection and retry!");
                done(examId);
            }
        }).done(function() {
            done(examId);
        })

    });

});

function done(examId) {
    $('#s' + examId).removeClass("spinner-border").removeClass("spinner-border-sm");
    $('#b' + examId).prop('disabled', false);
}