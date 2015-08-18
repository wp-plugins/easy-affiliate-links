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

    var shortcode = '[eafl id=' + id + ' name="' + EasyAffiliateLinks.htmlEncode(name) + '" text="' + EasyAffiliateLinks.htmlEncode(text) + '"]';

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

EasyAffiliateLinks.editShortcode = function(id, name, text) {
    var tinymce_active = false;
    if(typeof(EasyAffiliateLinks.tinymce) !== 'undefined' && EasyAffiliateLinks.tinymce != null && !EasyAffiliateLinks.tinymce.isHidden()) {
        tinymce_active = true;
    }

    var shortcode = '[eafl id=' + id + ' name="' + EasyAffiliateLinks.htmlEncode(name) + '" text="' + EasyAffiliateLinks.htmlEncode(text) + '"]';

    if(tinymce_active) { // Visual Editor
        console.log(EasyAffiliateLinks.editing_shortcode_id);
        var content = EasyAffiliateLinks.tinymce.getContent();

        // Make sure we replace the shortcode we were editing
        var shortcode_id = 0;
        content = content.replace( /\[eafl([^\]]*)\]/g, function( match ) {
            shortcode_id++;
            console.log(shortcode_id);
            if(shortcode_id != EasyAffiliateLinks.editing_shortcode_id) {
                return match;
            } else {
                console.log(shortcode);
                return shortcode;
            }
        });

        EasyAffiliateLinks.tinymce.setContent(content);
        EasyAffiliateLinks.tinymce.execCommand('mceRepaint');
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

EasyAffiliateLinks.addVariant = function() {
    jQuery('.eafl_variant').before('<tr class="eafl_variant_input"><td>&nbsp;</td><td><input type="text" name="eafl_text[]"></td><td>&nbsp;</td></tr>');
};

EasyAffiliateLinks.htmlEncode = function(str) {
    return str.replace(/"/g, "&quot;");
};

EasyAffiliateLinks.init = function($) {
    EasyAffiliateLinks.updateLinkPreview();
    $('#eafl_slug').on('keyup change', function() { EasyAffiliateLinks.updateLinkPreview(); });
    $('.eafl_variant a').on('click', function(e,v) {
        e.preventDefault();
        e.stopPropagation();
        EasyAffiliateLinks.addVariant();
    });

    // Lightbox Only
    $('#eafl_add_from_lightbox').on('submit', function(e) {
        e.preventDefault();

        var data = $(this).serialize();
        jQuery.post(eafl_admin.ajax_url, data, function(link) {
            parent.EasyAffiliateLinks.addShortcode(link.ID, link.name, link.text);
            parent.tb_remove();
        }, 'json');
    });

    $('#shortcode_link_submit').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        parent.EasyAffiliateLinks.editShortcode(jQuery('#eafl_id').val(), jQuery('#eafl_name').val(), jQuery('#shortcode_link_text').val());
        parent.tb_remove();
    });

    $('#eafl_edit_from_lightbox').on('submit', function(e) {
        e.preventDefault();

        var data = $(this).serialize();
        jQuery.post(eafl_admin.ajax_url, data, function(link) {
            parent.EasyAffiliateLinks.editShortcode(link.ID, link.name, link.text);
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

    $('.eafl_use_link').on('change', function() {
        var btn = $(this),
            text = btn.val();

        if(text == 'eafl_custom_link_text') {
            text = prompt('Link Text to use for: ' + btn.data('name'));
        }

        if(text != null && text !== 'eafl_select_link_text') {
            parent.EasyAffiliateLinks.addShortcode(btn.data('id'), btn.data('name'), text);
            parent.tb_remove();
        } else {
            btn.val('eafl_select_link_text');
        }
    });
};

jQuery(document).ready(function($) {
    if($('.eafl_form').length > 0) {
        EasyAffiliateLinks.init(jQuery);
    }
});