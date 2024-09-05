<!-- resources/views/components/success-message.blade.php -->
@if (session()->has('success') || session()->has('error'))
    <div class="modal fade" id="flashModal" tabindex="-1" role="dialog" aria-labelledby="flashModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    @if (session()->has('success'))
                        <div class="row text-center p-3">
                            <i class="text-success fa-regular fa-circle-check" style="font-size: 80px;"></i>
                        </div>
                        <div class="row text-center p-0">
                            <h4 class="rsans">Success!</h4>
                            <p class="rsans">{{ session('success') ?? 'Process successful.' }}</p>
                        </div>
                    @elseif (session()->has('error'))
                        <div class="row text-center p-3">
                            <i class="text-danger fa-regular fa-circle-xmark" style="font-size: 80px;"></i>
                        </div>
                        <div class="row text-center p-0">
                            <h4 class="rsans">Error</h4>
                            <p class="rsans">{{ session('error') ?? 'Error encountered.' }}</p>
                        </div>
                        {{ session('error') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the modal element
            const flashModal = document.getElementById('flashModal');
            // Check if the modal element exists
            if (flashModal) {
                console.log('Flash modal element found: ', flashModal);
                // Initialise the modal using BS's Modal class
                const modalInstance = new bootstrap.Modal(flashModal);
                // Show the modal
                modalInstance.show();
                // Set a timeout to hide the modal after 5 seconds
                setTimeout(function() {
                    modalInstance.hide();
                }, 5000);
            } else {
                console.error('Flash modal element not found');
            }
        });
    </script>
@endif
