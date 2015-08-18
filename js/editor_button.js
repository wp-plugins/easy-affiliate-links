var EasyAffiliateLinks = EasyAffiliateLinks || {};

EasyAffiliateLinks.tinymce = null;
EasyAffiliateLinks.editing_shortcode_id = null;

EasyAffiliateLinks.openLightbox = function(tinymce) {
    EasyAffiliateLinks.tinymce = tinymce;
    tb_show('Easy Affiliate Links', eafl_button.ajax_url + '&action=eafl_lightbox&height=640&width=640&TB_iframe=true');
};

EasyAffiliateLinks.openLightboxEdit = function(tinymce, shortcode_id, id, text) {
    EasyAffiliateLinks.tinymce = tinymce;
    EasyAffiliateLinks.editing_shortcode_id = shortcode_id;
    tb_show('Easy Affiliate Links', eafl_button.ajax_url + '&action=eafl_lightbox_edit&eafl_id=' + id + '&eafl_text=' + encodeURIComponent(text) + '&height=640&width=640&TB_iframe=true');
};

EasyAffiliateLinks.codeEditorButton = function() {
    if(typeof tinymce != 'undefined') {
        EasyAffiliateLinks.openLightbox(tinymce.activeEditor);
    } else {
        EasyAffiliateLinks.openLightbox();
    }
};

// Code Editor Button
jQuery(document).ready(function($) {
    if (typeof QTags != 'undefined') {
        QTags.addButton('Easy_Affiliate_Link', 'easy affiliate link', EasyAffiliateLinks.codeEditorButton, '', '', 'Easy Affiliate Link', 30);
    }
});