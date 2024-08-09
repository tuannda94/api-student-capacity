const pageCkeditor = {
    classicCk: function () {
        ClassicEditor.create(
            document.querySelector("#kt_docs_ckeditor_classic"),
            {
                alignment: {
                    options: ['left', 'right', 'center', 'justify',]
                },
                // plugins: [ CKFinder, CKFinderUploadAdapter],
                toolbar: [
                    "heading",
                    "undo",
                    "redo",
                    "bold",
                    "italic",
                    "blockQuote",
                    "ckfinder",
                    "imageTextAlternative",
                    '|',
                    'alignment',
                    '|',
                    "uploadImage",
                    // "heading",
                    "imageStyle:full",
                    "imageStyle:side",
                    "link",
                    "numberedList",
                    "bulletedList",
                    "insertTable",
                    "mediaEmbed",
                    "tableColumn",
                    "tableRow",
                    "mergeTableCells",
                ],
                ckfinder: {
                    // Upload the images to the server using the CKFinder QuickUpload command.
                    uploadUrl: 'https://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                },
            }
        )
            .then((editor) => {
            })
            .catch((error) => {
            });
    },
    classicCk2: function () {
        ClassicEditor.create(
            document.querySelector("#kt_docs_ckeditor_classic2"),
            {
                alignment: {
                    options: ['left', 'right', 'center', 'justify',]
                },
                toolbar: [
                    "heading",
                    "undo",
                    "redo",
                    "bold",
                    "italic",
                    "blockQuote",
                    "ckfinder",
                    "imageTextAlternative",
                    '|',
                    'alignment:left',
                    'alignment:right',
                    'alignment:center',
                    'alignment:justify',
                    '|',
                    "imageUpload",
                    // "heading",
                    "imageStyle:full",
                    "imageStyle:side",
                    "link",
                    "numberedList",
                    "bulletedList",
                    "mediaEmbed",
                    "insertTable",
                    "tableColumn",
                    "tableRow",
                    "mergeTableCells",
                ],
            }
        )
            .then((editor) => {
            })
            .catch((error) => {
            });
    },
};
pageCkeditor.classicCk();
pageCkeditor.classicCk2();
