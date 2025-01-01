<!-- resources/views/components/feedback.blade.php -->
<div class="rsans modal fade" id="feedback-modal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0" id="about-modal-label">
                    We value your feedback!
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-3">
                <div class="row d-flex justify-content-center align-items-center">
                    <p>
                        Your input helps us improve. Please scan the QR code below or click <a href="https://forms.gle/Na2aDULgod7qHmf67" target="_blank" rel="noopener noreferrer" class="rsans fw-semibold link">this link</a> to share your thoughts.
                    </p>
                    <img src="{{ asset('images/SUSGForm_010125_1750.png') }}" alt="Feedback QR Code" class="w-60 mt-2 mb-4">
                    <p>
                        Thank you for taking the time to help us grow!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>