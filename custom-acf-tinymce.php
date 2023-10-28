<?php
/*
Plugin Name: ACF Custom Button
Description: Adds a custom button to the ACF TinyMCE toolbar
Version: 1.0
Author: Maxime Bajeux
*/

function my_acf_input_admin_footer() {
?>
<script type="text/javascript">

acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, field) {
    mceInit.verify_html = false;
    mceInit.plugins = 'textcolor,colorpicker,lists,fullscreen,image,wordpress,wpeditimage,wplink,hr';
    mceInit.toolbar1 = 'formatselect,bold,italic,underline,strikethrough,forecolor,blockquote,hr';
    mceInit.toolbar2 = 'alignleft,aligncenter,alignright,alignjustify,bullist,numlist,link,unlink,undo,redo,removeformat,customButton';
    mceInit.setup = function(ed){
        ed.addButton( 'customButton', {
            type: 'button',
            text: 'CTA',
            onclick: function() {
                // Open a TinyMCE modal window
                ed.windowManager.open({
                    title: 'Insert CTA Link',
                    body: [
                        {type: 'textbox', name: 'url', label: 'URL'},
                        {type: 'checkbox', name: 'newTab', label: 'Open in a new tab', checked: true},
                    ],
                    onsubmit: function(e) {
                        var url = e.data.url;
                        var newTab = e.data.newTab ? ' target="_blank"' : '';
                        var selected_text = ed.selection.getContent();
                        var html = '<a class="cta" href="' + url + '"' + newTab + '>' + selected_text + '</a>';
                        ed.execCommand('mceInsertContent', false, html);
                    }
                });
            }
        });
    }
    return mceInit;
});

</script>
<?php
}

add_action('acf/input/admin_footer', 'my_acf_input_admin_footer');
?>
