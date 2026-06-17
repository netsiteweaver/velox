jQuery(function(){
    $('.btn-copy-param').on('click', function() {
        var text = $(this).attr('data-copy');

        function copied() {
            toastr.success('Copied to clipboard');
        }

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(copied);
            return;
        }

        var $temp = $('<textarea>');
        $('body').append($temp);
        $temp.val(text).select();
        document.execCommand('copy');
        $temp.remove();
        copied();
    });
})