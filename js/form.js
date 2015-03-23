var EasyAffiliateLinks = EasyAffiliateLinks || {};

EasyAffiliateLinks.convertToSlug = function(text) {
    return text.toLowerCase()
        .replace(/ /g,'-')
        .replace(/[-]+/g, '-')
        .replace(/[^\w-]+/g,'');
};

EasyAffiliateLinks.updateLinkPreview = function() {
    //var prefix_input = jQuery('#eafl_prefix');
    var slug_input = jQuery('#eafl_slug');

    // Validate slugs
    //var prefix = EasyAffiliateLinks.convertToSlug(prefix_input.val());
    var slug = EasyAffiliateLinks.convertToSlug(slug_input.val());

    //if(prefix_input.val() != prefix) prefix_input.val(prefix);
    if(slug_input.val() != slug) slug_input.val(slug);

    // Update Preview
    var link = '';

    //if( prefix != '' ) {
    //    link = prefix + '/';
    //}
    link = link + slug;

    jQuery('#eafl_link_preview').text( link );
};


EasyAffiliateLinks.addShortcode = function(id, name, text) {
    var tinymce_active = false;
    if(typeof(EasyAffiliateLinks.tinymce) !== 'undefined' && EasyAffiliateLinks.tinymce != null && !EasyAffiliateLinks.tinymce.isHidden()) {
        tinymce_active = true;
    }

    var shortcode = '[eafl id=' + id + ' name="' + name.replace('"',"'") + '" text="' + text.replace('"',"'") + '"]';

    if(tinymce_active) { // Visual Editor
        EasyAffiliateLinks.tinymce.focus();
        EasyAffiliateLinks.tinymce.selection.setContent(shortcode);
        EasyAffiliateLinks.tinymce.execCommand('mceRepaint');
    } else { // Code Editor
        var el;
        el = document.getElementById('replycontent');
        if (typeof el == 'undefined' || !jQuery(el).is(':visible')) // Not a comment reply
            el = document.getElementById('content');

        var sel = EasyAffiliateLinks.getCodeEditorSelection();
        var val = el.value;
        el.value = val.slice(0, sel.start) + shortcode + val.slice(sel.end);
        jQuery(el).trigger('change');
    }
};

EasyAffiliateLinks.getCodeEditorSelection = function() {
    var textComponent;
    textComponent = document.getElementById('replycontent');
    if (typeof textComponent == 'undefined' || !jQuery(textComponent).is(':visible')) // Not a comment reply
        textComponent = document.getElementById("content");

    var selectedText = {};

    if (parent.document.selection != undefined) { // IE
        textComponent.focus();
        var sel = parent.document.selection.createRange();
        selectedText.text = sel.text;
        selectedText.start = sel.start;
        selectedText.end = sel.end;
    } else if (textComponent.selectionStart != undefined) { // Mozilla
        var startPos = textComponent.selectionStart;
        var endPos = textComponent.selectionEnd;
        selectedText.text = textComponent.value.substring(startPos, endPos)
        selectedText.start = startPos;
        selectedText.end = endPos;
    }

    return selectedText;
};

jQuery(document).ready(function($) {
    if($('.eafl_form').length > 0) {
        EasyAffiliateLinks.updateLinkPreview();
        $('#eafl_slug').on('keyup change', function() { EasyAffiliateLinks.updateLinkPreview(); });

        // Lightbox Only
        $('#eafl_add_from_lightbox').on('submit', function(e) {
            e.preventDefault();

            var data = $(this).serialize();
            jQuery.post(eafl_admin.ajax_url, data, function(link) {
                parent.EasyAffiliateLinks.addShortcode(link.ID, link.name, link.text);
                parent.tb_remove();
            }, 'json');
        });

        $('#eafl_lightbox_tabs').tabs();
        $('#eafl_select_link').filterTable({
            autofocus: true,
            minRows: 0,
            label: eafl_admin.search_link_label,
            placeholder: ''
        });

        $('.eafl_use_link').on('click', function() {
            var btn = $(this);

            parent.EasyAffiliateLinks.addShortcode(btn.data('id'), btn.data('name'), btn.data('text'));
            parent.tb_remove();
        });
    }
});