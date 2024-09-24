<!-- resources/views/components/learning-style-radio-group.blade.php -->
@props(['label', 'type', 'value'])
<div class="rserif form-group w-100 fs-4 py-2 mb-4">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-2 d-flex justify-content-center align-items-center">
            <div class="form-check custom-radio mb-1">
                <input class="form-check-input md-radio" type="radio" name="learning_style" id="learning-style-{{ $type }}" value="{{ $value }}" required>
            </div>
        </div>
        <div class="col-md-10">
            <label class="form-check-label" for="learning-style-{{ $type }}">
                {{ $label }}
            </label>
        </div>
    </div>
</div>
