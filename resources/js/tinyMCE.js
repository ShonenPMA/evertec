
const hinputs = document.querySelectorAll('.hinput');
import tinymce from 'tinymce/tinymce'
import 'tinymce/icons/default/'
import 'tinymce/themes/silver/'
import 'tinymce-langs/langs/es_MX'

import 'tinymce/plugins/hr/plugin'
import 'tinymce/plugins/lists/plugin'
import 'tinymce/plugins/advlist/plugin'
import 'tinymce/plugins/link/plugin'
import 'tinymce/plugins/image/plugin'
import 'tinymce/plugins/imagetools/plugin'
import 'tinymce/plugins/paste/plugin'

import 'tinymce/plugins/emoticons/js/emojis'
import 'tinymce/plugins/emoticons/plugin'
import 'tinymce/plugins/table/plugin'
import 'tinymce/plugins/searchreplace/plugin'
import 'tinymce/plugins/fullscreen/plugin'

// const tinyMCE_logo= document.getElementById('tinyMCE_logo');
// const tinyMCE_logo_reverse= document.getElementById('tinyMCE_logo_reverse');
Array.prototype.forEach.call(hinputs, function(hinput){
    const id = hinput.getAttribute('id').replace('hinput','');
    tinymce.init({
        selector: '#'+id,
        menubar:false,
        plugins: 'hr lists advlist  link image imagetools paste emoticons table searchreplace fullscreen',
        toolbar: 'undo redo | fontselect fontsizeselect | forecolor backcolor | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent |  hr |  link | image | emoticons | table | searchreplace | fullscreen',
        // image_list: [
        //     {title: 'Logo', value: tinyMCE_logo.value},
        //     {title: 'Logo inverso', value: tinyMCE_logo_reverse.value},
        // ],
        paste_block_drop: false,
        paste_as_text: true,
        font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; Cinzel=cinzel; Cardo=cardo;Casad Serial=casad serial',
        link_class_list: [
            {title: 'None', value: ''},
            {title: 'Botón negro', value: 'font-serif text-sm text-gray-800 font-semibold mt-4 p-4 border-0  inline-block w-auto  bg-smoke-500 hover:bg-smoke-800 transition-all duration-500 cursor-pointer'},

        ],
        automatic_uploads: true,
        images_upload_url: '/uploadImage',
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            /*
            Note: In modern browsers input[type="file"] is functional without
            even adding it to the DOM, but that might not be the case in some older
            or quirky browsers like IE, so you might want to add it to the DOM
            just in case, and visually hide it. And do not forget do remove it
            once you do not need it anymore.
            */

            input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {
                /*
                Note: Now we need to register the blob in TinyMCEs image blob
                registry. In the next release this part hopefully won't be
                necessary, as we are looking to handle it internally.
                */
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        },
        tinycomments_author: 'Jhon Saavedra',
        height: "500",
        language: "es_MX",
        setup: function(editor) {
            editor.on('change', function(e) {
                const textarea = document.querySelector('#'+id);
                textarea.value = editor.getContent();
                });
            }
   });
});
