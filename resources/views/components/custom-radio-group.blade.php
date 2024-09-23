<!-- resources/views/components/custom-radio-group.blade.php -->
@props(['label', 'name'])
<div class="rserif form-group w-100 text-center fs-4 py-2">
    <div class="row align-items-center justify-content-center text-center pb-2">
        {{ $label }}
    </div>
    <div class="row mt-2 align-items-center justify-content-center">
        <div class="col-md-3">Strongly disagree</div>
        <div class="col-md-6">
            <!-- Radio button group -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input xs-radio" type="radio" name="{{ $name }}" id="disagree-strong" value="1">
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input sm-radio" type="radio" name="{{ $name }}" id="disagree" value="2">
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input md-radio" type="radio" name="{{ $name }}" id="neutral" value="3" checked>
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input lg-radio" type="radio" name="{{ $name }}" id="agree" value="4">
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input xl-radio" type="radio" name="{{ $name }}" id="agree-strong" value="5">
                </div>
            </div>
        </div>
        <div class="col-md-3">Strongly agree</div>
    </div>
</div>
<br>
<div class="row w-100 border-bottom mb-4"></div>
