<!-- resources/views/components/skills-radio-group.blade.php -->
@props(['label', 'name'])
<div class="rsans form-group w-100 text-center fs-4 py-2">
    <div class="row align-items-center justify-content-center text-center pb-2">
        {{ $label }}
    </div>
    <div class="row mt-2 align-items-center justify-content-center">
        <!-- Radio button group -->
        <div class="col-lg-12">
            <div class="rg-center d-flex justify-content-between align-items-center">
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input xxs-radio" type="radio" name="{{ $name }}" id="{{ $name }}-strongly-disagree" value="1" required>
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input xs-radio" type="radio" name="{{ $name }}" id="{{ $name }}-disagree" value="2">
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input sm-radio" type="radio" name="{{ $name }}" id="{{ $name }}-somewhat-disagree" value="3">
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input md-radio" type="radio" name="{{ $name }}" id="{{ $name }}-neutral" value="4">
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input lg-radio" type="radio" name="{{ $name }}" id="{{ $name }}-somewhat-agree" value="5">
                </div>
                <div class="form-check form-check-inline custom-radio">
                    <input class="form-check-input xl-radio" type="radio" name="{{ $name }}" id="{{ $name }}-agree" value="6">
                </div>
                <div class="form-check form-check-inline custom-radio me-0">
                    <input class="form-check-input xxl-radio" type="radio" name="{{ $name }}" id="{{ $name }}-strongly-agree" value="7">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="rsans rg-left col-6 text-start fw-light">Strongly disagree</div>
        <div class="rsans rg-right col-6 text-end fw-light">Strongly agree</div>
    </div>
    <br>
    <div class="row w-100 border-bottom mx-0 mb-4"></div>
</div>
