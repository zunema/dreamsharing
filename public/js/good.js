
$(function(){

    const likeItemId = $('#likeItem');
    const DELETE = "0";
    const INSERT = "1";
    const l = console.log;

    $('.like').on('click',function(){
        var user_id = $(this).data("user_id");
        var post_id = $(this).data("post_id");
        $.ajax({
            type: 'POST',
            url: 'ajaxGood.php',
            data: { userId: user_id, postId: post_id} //{キー:投稿ID}
        }).done(function(data){
            if (data === INSERT) {
                removeProp();
                addProp('fas fa-heart', true)
            } else if (data === DELETE) {
                removeProp();
                addProp('far fa-heart')
            }
        }).fail(function(msg) {
            console.log('Ajax Error');
        })
    });

    /**
     * @param void
     * @return void
     */
    function removeProp() {
        likeItemId.removeClass().css("color","")
    }

    /**
     * @param string className
     * @param bool css
     */
    function addProp(className,  css = false) {
        let elem = likeItemId.addClass(className)
        css ? likeItemId.css('color', 'red') : elem;
    }
});


