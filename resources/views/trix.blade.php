<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://www.unpkg.com/trix@2.0.5/dist/trix.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-5">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h6 class="text-white">{{ __('Trix image upload') }}</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <input id="description" type="hidden"/>
                                    <trix-editor input="description" class="trix-content" autofocus></trix-editor>
                                </div>
                                <!--<div class="row mb-0 text-center">
                                    <button type="submit" class="btn btn-success btn-sm">{{ __('Save') }}</button>
                                </div>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://www.unpkg.com/trix@2.0.5/dist/trix.umd.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            (function() {
                var HOST = "{{ config('app.url') }}"
                addEventListener("trix-attachment-add", function(event) {
                    if (event.attachment.file) {
                        uploadFileAttachment(event.attachment);
                    }
                })

                function uploadFileAttachment(attachment) {
                    uploadFile(attachment.file, setProgress, setAttributes);

                    function setProgress(progress) {
                        attachment.setUploadProgress(progress);
                    }

                    function setAttributes(attributes) {
                        attachment.setAttributes(attributes);
                    }
                }

                function uploadFile(file, progressCallback, successCallback) {
                    var formData = createFormData(file);
                    var xhr = new XMLHttpRequest();

                    xhr.open("POST", "{{ route('trix.upload') }}", true);
                    xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
                    xhr.upload.addEventListener("progress", function(event) {
                        var progress = event.loaded / event.total * 100;
                        progressCallback(progress);
                    })

                    xhr.addEventListener("load", function(event) {
                        if (xhr.status == 200) {
                            var response = jQuery.parseJSON(xhr.response);
                            var attributes = {
                                url: response.url,
                                href: response.url
                            }
                            successCallback(attributes);
                        }
                    })

                    xhr.send(formData);
                }

                function createFormData(file) {
                    var data = new FormData();
                    data.append("Content-Type", file.type);
                    data.append("upload", file);
                    return data;
                }
            })();
        </script>
    </body>
</html>