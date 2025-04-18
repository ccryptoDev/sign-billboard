<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="A jQuery plugin wrapper for Cropper.js.">
        <meta name="author" content="Chen Fengyuan">
        <title>jquery-cropper</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css" crossorigin="anonymous">
        <link rel="stylesheet" href="/crop/css/main.css">
    </head>
    <body>
        <!--[if lt IE 9]>
        <div class="alert alert-warning alert-dismissible fade show m-0 rounded-0" role="alert">
            You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <![endif]-->
        <!-- Header -->
        <header class="navbar navbar-light navbar-expand-md">
            <div class="container">
                <a class="navbar-brand" href="./">jquery-cropper</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-collapse" role="navigation">
                    <nav class="nav navbar-nav">
                        <a class="nav-link" href="https://github.com/fengyuanchen/jquery-cropper/blob/master/README.md" data-toggle="tooltip" title="View the documentation">Docs</a>
                        <a class="nav-link" href="https://github.com/fengyuanchen/jquery-cropper" data-toggle="tooltip" title="View the GitHub project">GitHub</a>
                        <a class="nav-link" href="https://fengyuanchen.github.io/cropperjs" data-toggle="tooltip" title="JavaScript image cropper">Cropper.js</a>
                        <a class="nav-link" href="https://fengyuanchen.github.io/" data-toggle="tooltip" title="Explore more projects">Explore</a>
                        <a class="nav-link" href="https://chenfengyuan.com/" data-toggle="tooltip" title="About the author">About</a>
                    </nav>
                </div>
            </div>
        </header>
        <!-- Jumbotron -->
        <div class="jumbotron bg-primary text-white rounded-0">
            <div class="container">
                <div class="row">
                    <div class="col-md">
                        <h1>jquery-cropper <small class="h6">v1.0.1</small></h1>
                        <p class="lead">A jQuery plugin wrapper for Cropper.js.</p>
                    </div>
                    <div class="col-md">
                        <div class="carbonads">
                            <!-- <script id="_carbonads_js" src="https://cdn.carbonads.com/carbon.js?serve=CKYI55Q7&placement=fengyuanchengithubio" async></script> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <!-- <h3>Demo:</h3> -->
                    <div class="img-container">
                        <img id="image" src="/crop/images/picture.jpg" alt="Picture">
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- <h3>Preview:</h3> -->
                    <div class="docs-preview clearfix">
                        <div class="img-preview preview-lg"></div>
                        <div class="img-preview preview-md"></div>
                        <div class="img-preview preview-sm"></div>
                        <div class="img-preview preview-xs"></div>
                    </div>
                    <!-- <h3>Data:</h3> -->
                    <div class="docs-data" style="display:none">
                        <div class="input-group input-group-sm">
                            <span class="input-group-prepend">
                            <label class="input-group-text" for="dataX">X</label>
                            </span>
                            <input type="text" class="form-control" id="dataX" placeholder="x">
                            <span class="input-group-append">
                            <span class="input-group-text">px</span>
                            </span>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-prepend">
                            <label class="input-group-text" for="dataY">Y</label>
                            </span>
                            <input type="text" class="form-control" id="dataY" placeholder="y">
                            <span class="input-group-append">
                            <span class="input-group-text">px</span>
                            </span>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-prepend">
                            <label class="input-group-text" for="dataWidth">Width</label>
                            </span>
                            <input type="text" class="form-control" id="dataWidth" placeholder="width">
                            <span class="input-group-append">
                            <span class="input-group-text">px</span>
                            </span>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-prepend">
                            <label class="input-group-text" for="dataHeight">Height</label>
                            </span>
                            <input type="text" class="form-control" id="dataHeight" placeholder="height">
                            <span class="input-group-append">
                            <span class="input-group-text">px</span>
                            </span>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-prepend">
                            <label class="input-group-text" for="dataRotate">Rotate</label>
                            </span>
                            <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                            <span class="input-group-append">
                            <span class="input-group-text">deg</span>
                            </span>
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-prepend">
                            <label class="input-group-text" for="dataScaleX">ScaleX</label>
                            </span>
                            <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                        </div>
                        <div class="input-group input-group-sm">
                            <span class="input-group-prepend">
                            <label class="input-group-text" for="dataScaleY">ScaleY</label>
                            </span>
                            <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 docs-buttons">
                    <!-- <h3>Toolbar:</h3> -->
                    <div class="btn-group">

                        <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                            <span class="fa fa-arrows-alt"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, 0.1)">
                        <span class="fa fa-search-plus"></span>
                        </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, -0.1)">
                        <span class="fa fa-search-minus"></span>
                        </span>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, -10, 0)">
                        <span class="fa fa-arrow-left"></span>
                        </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 10, 0)">
                        <span class="fa fa-arrow-right"></span>
                        </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, -10)">
                        <span class="fa fa-arrow-up"></span>
                        </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, 10)">
                        <span class="fa fa-arrow-down"></span>
                        </span>
                        </button>
                    </div>
                    <div class="btn-group">
                        <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                        <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image with Blob URLs">
                        <span class="fa fa-upload"></span>
                        </span>
                        </label>
                    </div>
                    <div class="btn-group btn-group-crop">
                        <button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;getCroppedCanvas&quot;, { maxWidth: 4096, maxHeight: 4096 })">
                            Get Cropped Canvas
                        </span>
                        </button>
                    </div>
                    <!-- Show the cropped image in modal -->
                    <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->
                </div>
                <!-- /.docs-buttons -->
                <div class="col-md-3 docs-toggles" style="display:none">
                    <!-- <h3>Toggles:</h3> -->
                    <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                        <label class="btn btn-primary active">
                        <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">
                        16:9
                        </span>
                        </label>
                        <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 4 / 3">
                        4:3
                        </span>
                        </label>
                        <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 1 / 1">
                        1:1
                        </span>
                        </label>
                        <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">
                        2:3
                        </span>
                        </label>
                        <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: NaN">
                        Free
                        </span>
                        </label>
                    </div>
                    <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                        <label class="btn btn-primary active">
                        <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="View Mode 0">
                        VM0
                        </span>
                        </label>
                        <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="View Mode 1">
                        VM1
                        </span>
                        </label>
                        <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="View Mode 2">
                        VM2
                        </span>
                        </label>
                        <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="View Mode 3">
                        VM3
                        </span>
                        </label>
                    </div>
                    <div class="dropdown dropup docs-options">
                        <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
                        Toggle Options
                        <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="responsive" type="checkbox" name="responsive" checked>
                                    <label class="form-check-label" for="responsive">responsive</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="restore" type="checkbox" name="restore" checked>
                                    <label class="form-check-label" for="restore">restore</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="checkCrossOrigin" type="checkbox" name="checkCrossOrigin" checked>
                                    <label class="form-check-label" for="checkCrossOrigin">checkCrossOrigin</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="checkOrientation" type="checkbox" name="checkOrientation" checked>
                                    <label class="form-check-label" for="checkOrientation">checkOrientation</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="modal" type="checkbox" name="modal" checked>
                                    <label class="form-check-label" for="modal">modal</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="guides" type="checkbox" name="guides" checked>
                                    <label class="form-check-label" for="guides">guides</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="center" type="checkbox" name="center" checked>
                                    <label class="form-check-label" for="center">center</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="highlight" type="checkbox" name="highlight" checked>
                                    <label class="form-check-label" for="highlight">highlight</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="background" type="checkbox" name="background" checked>
                                    <label class="form-check-label" for="background">background</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="autoCrop" type="checkbox" name="autoCrop" checked>
                                    <label class="form-check-label" for="autoCrop">autoCrop</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="movable" type="checkbox" name="movable" checked>
                                    <label class="form-check-label" for="movable">movable</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="rotatable" type="checkbox" name="rotatable" checked>
                                    <label class="form-check-label" for="rotatable">rotatable</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="scalable" type="checkbox" name="scalable" checked>
                                    <label class="form-check-label" for="scalable">scalable</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="zoomable" type="checkbox" name="zoomable" checked>
                                    <label class="form-check-label" for="zoomable">zoomable</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="zoomOnTouch" type="checkbox" name="zoomOnTouch" checked>
                                    <label class="form-check-label" for="zoomOnTouch">zoomOnTouch</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="zoomOnWheel" type="checkbox" name="zoomOnWheel" checked>
                                    <label class="form-check-label" for="zoomOnWheel">zoomOnWheel</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="cropBoxMovable" type="checkbox" name="cropBoxMovable" checked>
                                    <label class="form-check-label" for="cropBoxMovable">cropBoxMovable</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="cropBoxResizable" type="checkbox" name="cropBoxResizable" checked>
                                    <label class="form-check-label" for="cropBoxResizable">cropBoxResizable</label>
                                </div>
                            </li>
                            <li class="dropdown-item">
                                <div class="form-check">
                                    <input class="form-check-input" id="toggleDragModeOnDblclick" type="checkbox" name="toggleDragModeOnDblclick" checked>
                                    <label class="form-check-label" for="toggleDragModeOnDblclick">toggleDragModeOnDblclick</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /.dropdown -->
                    <a class="btn btn-success btn-block" data-toggle="tooltip" data-animation="false" href="https://fengyuanchen.github.io/cropperjs" title="JavaScript image cropper">Cropper.js</a>
                </div>
                <!-- /.docs-toggles -->
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <p class="heart"></p>
                <nav class="nav flex-wrap justify-content-center mb-3">
                    <a class="nav-link" href="https://github.com/fengyuanchen/jquery-cropper">GitHub</a>
                    <a class="nav-link" href="https://github.com/fengyuanchen/jquery-cropper/blob/master/LICENSE">License</a>
                    <a class="nav-link" href="https://chenfengyuan.com/">About</a>
                </nav>
            </div>
        </footer>
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://fengyuanchen.github.io/shared/google-analytics.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/cropperjs/dist/cropper.js" crossorigin="anonymous"></script>
        <script src="/crop/js/jquery-cropper.js"></script>
        <script src="/crop/js/main.js"></script>
    </body>
</html>