<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" integrity="sha512-GQGU0fMMi238uA+a/bdWJfpUGKUkBdgfFdgBm72SUQ6BeyWjoY/ton0tEjH+OSH9iP4Dfh+7HM0I9f5eR0L/4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Trix 圖片上傳</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-2 mt-5">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h6 class="text-white">Trix 圖片上傳</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input id="description" type="hidden"/>
                                    <trix-editor input="description" class="trix-content" autofocus></trix-editor>
                                </div>
                                <!--<div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btn-sm">儲存</button>
                                </div>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.min.js" integrity="sha512-OvBgP9A2JBgiRad/mM36mkzXSXaJE9BEIENnVEmeZdITvwT09xnxLtT4twkCa8m/loMbPHsvPl0T8lRGVBwjlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js" integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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